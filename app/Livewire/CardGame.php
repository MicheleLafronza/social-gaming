<?php

namespace App\Livewire;

use Livewire\Component;
use App\Services\TwitchService;
use App\Models\Game;
use Illuminate\Support\Facades\Http;
use Illuminate\Support\Facades\Validator;

class CardGame extends Component
{
    public $game;
    public $gameStatus = '';

    public function addGame($gameToAddId)
    {

        $twitchService = app(TwitchService::class);
        $twitchAccessToken = $twitchService->getTwitchToken();
        $twitchClientId = env('TWITCH_CLIENT_ID');

        $response = Http::withHeaders([
            'Client-ID' => $twitchClientId,
            'Authorization' => 'Bearer ' . $twitchAccessToken,
        ])->withBody("
        fields name, cover.image_id, platforms.abbreviation, release_dates.human, screenshots.image_id;
        where id = $gameToAddId;
        ", 'text/plain')->post('https://api.igdb.com/v4/games');
        
        $gameToAdd = json_decode($response->getBody()->getContents());

        $gameToValidate = [
            'igdb_id' => $gameToAdd[0]->id,
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

        $validator = Validator::make($gameToValidate, [
            'igdb_id' => 'required|integer|unique:games,igdb_id',
            'name' => 'required|string|max:255',
            'game_state' => 'required|string|max:255',
            'cover_id' => 'nullable|string|max:255',
            'release_date' => 'nullable|string|max:255',
            'screenshots_id' => 'nullable|array',
            'platforms' => 'nullable|array',
        ]);

        // Se la validazione fallisce
        if ($validator->fails()) {
            // Puoi fare qualcosa qui (es. reindirizzare, flashare un messaggio, ecc.)
            // Gli errori sono automaticamente gestiti da Livewire
            $this->addError('gameToValidate.igdb_id', 'Esiste già');

            // Optional: Puoi reindirizzare a una pagina o rimanere sulla stessa pagina
            return redirect(route('search.game'));
    }

        $gameValidated = $validator->validated();

        Game::create($gameValidated);

        // Messaggio di successo
        session()->flash('message', 'Gioco aggiunto!!');

        return redirect(route('search.game'));

    }

    public function render()
    {
        return view('livewire.card-game');
    }

}
