<?php

namespace App\Livewire;

use Livewire\Component;
use App\Services\TwitchService;
use App\Models\Game;
use App\Models\User;
use Illuminate\Support\Facades\Http;
use Illuminate\Support\Facades\Validator;

class CardGame extends Component
{
    public $game;
    public $gameStatus = 'completed';
    public $gameOnDb = false;
    public $gameOnUser = false;
    public $canAdd = true;

    public function mount() 
    {
        // prendo id dell'api IGDB e la associo ad una variabile
        $gameIgdbId = $this->game->id;

        // check se il gioco è gia sul datbase
        $this->gameOnDb = Game::where('igdb_id', $gameIgdbId)->exists();

        // se il gioco è presente sul database cerchiamo se è già collegato all'utente
        if ($this->gameOnDb) {

            // gioco da tenere in considerazione
            $dbGame = Game::where('igdb_id', $gameIgdbId)->first();

            // recuperiamo id primary del gioco partendo dal igdb
            $dbGameId = $dbGame->id;

            // recuperiamo tutti gli utenti che sono associati al gioco
            $usersWithGame = $dbGame->users()->pluck('users.id')->toArray();

            // controllo se l'utente associato è tra gli utenti, ritorna true se è associato, altrimenti ritorna false
            $this->gameOnUser = in_array(auth()->id(), $usersWithGame);

        } else {
            // altrimenti ritorna false
            $this->gameOnUser = false;
        }

        // se il gioco è già presente sul database ed è associato all'utente
        if ($this->gameOnDb && $this->gameOnUser) {

            // viene messa una spunta e non è possibile aggiungerlo
            $this->canAdd = false;

        } elseif ($this->gameOnDb && !$this->gameOnUser) {

            // se il gioco è presente sul database ma non sull'utente, è possibile aggiungerlo
            $this->canAdd = true;

        } elseif (!$this->gameOnDb && !$this->gameOnUser) {

            // se il gioco non è presente sul database e nemmeno sull'utente, è possibile aggiungerlo
            $this->canAdd = true;

        }
    }

    public function addGame()
    {
        $gameIgdbId = $this->game->id;

        // se il gioco è presente sul database ma non sull'utente, non va registrato nuovamente, ma va solo associato all'utente
        if ($this->gameOnDb && !$this->gameOnUser) {

            // gioco da tenere in considerazione
            $dbGame = Game::where('igdb_id', $gameIgdbId)->first();

            // aggiungiamo il gioco all'utente
            auth()->user()->games()->attach($dbGame->id);

            // Messaggio di successo
            session()->flash('message', 'Gioco aggiunto!!');

            // torniamo sulla pagina di search con il messaggio di successo
            return redirect(route('search.game'));
        } else {

            // altrimenti avviamo tutta la procedura di registrazione del nuovo gioco sul nostro database

            // avviamo il twitchservuce che grazie al client id e al secret id nell'env ci da un nuovo token se il vecchio è expired
            $twitchService = app(TwitchService::class);
            $twitchAccessToken = $twitchService->getTwitchToken();
            $twitchClientId = env('TWITCH_CLIENT_ID');

            // chiamata all'api di IGDB con tutti i dati che ci servono
            $response = Http::withHeaders([
                'Client-ID' => $twitchClientId,
                'Authorization' => 'Bearer ' . $twitchAccessToken,
            ])->withBody("
            fields name, cover.image_id, platforms.abbreviation, release_dates.human, screenshots.image_id;
            where id = $gameIgdbId;
            ", 'text/plain')->post('https://api.igdb.com/v4/games');
            
            // trasformiamo la risposta in un file json
            $gameToAdd = json_decode($response->getBody()->getContents());

            // associamo i dati del gioco nel file json ad un array con le proprietà del gioco
            $gameToValidate = [
                'igdb_id' => intval($gameToAdd[0]->id),
                'name' => $gameToAdd[0]->name,
                'game_state' => $this->gameStatus,
                'cover_id' => $gameToAdd[0]->cover->image_id ?? 'null',
                'release_date' => $gameToAdd[0]->release_dates[0]->human ?? 'null',

                'screenshots_id' => isset($gameToAdd[0]->screenshots) ? array_map(function($screenshot) {
                    return $screenshot->image_id;
                }, $gameToAdd[0]->screenshots) : null,

                'platforms' => isset($gameToAdd[0]->platforms) ? array_map(function($platform) {
                    return $platform->abbreviation;
                }, $gameToAdd[0]->platforms) : null,

            ];

            // settiamo le regole della validazione e diamo i dati per la validazione stessa
            $validator = Validator::make($gameToValidate, [
                'igdb_id' => 'required|integer|unique:games,igdb_id',
                'name' => 'required|string|max:255',
                'game_state' => 'string|max:255',
                'cover_id' => 'nullable|string|max:255',
                'release_date' => 'nullable|string|max:255',
                'screenshots_id' => 'nullable|array',
                'screenshots_id.*' => 'string|max:255',
                'platforms' => 'nullable|array',
                'platforms.*' => 'string|max:255',
            ]);

            // se la validazione fallisce abbiamo dei messaggi di errore che stampiamo in pagina
            if ($validator->fails()) {
                foreach ($validator->errors()->messages() as $field => $messages) {
                    foreach ($messages as $message) {
                        $this->addError($field, $message);
                    }
                }
                return;
            }

            // se la validazione non fallisce diamo per validated il gioco
            $gameValidated = $validator->validated();

            // salviamo nel database il nuovo gioco con i dati validati
            $newGame = Game::create($gameValidated);

            // associamo all'utente il gioco creato
            auth()->user()->games()->attach($newGame->id);

            // Messaggio di successo
            session()->flash('message', 'Gioco aggiunto!!');

            // ritorno alla route di search
            return redirect(route('search.game'));

        }
    }

    public function render()
    {
        return view('livewire.card-game');
    }

}
