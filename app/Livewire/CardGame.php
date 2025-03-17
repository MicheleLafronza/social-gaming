<?php

namespace App\Livewire;

use Livewire\Component;
use App\Services\TwitchService;
use Illuminate\Support\Facades\Http;
use Illuminate\Http\Request;


class CardGame extends Component
{
    public $game;
    public $gameStatus = '';

    public function addGame($gameToAddId): array
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
        

        $gametoAdd = json_decode($response->getBody()->getContents());

        dd($this->gameStatus);

        $gameToValidate = [
            'igdb_id' => $gametoAdd[0]->id,
            'name' => $gametoAdd[0]->name,
        ];
        
        
    }

    public function render()
    {
        return view('livewire.card-game');
    }

}
