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

            'screenshots_id' => isset($gameToAdd[0]->screenshots) ? json_encode(array_map(function($screenshot) {
                return $screenshot->image_id;
            }, $gameToAdd[0]->screenshots)) : null,

            'platforms' => isset($gameToAdd[0]->platforms) ? json_encode(array_map(function($platform) {
                return $platform->abbreviation;
            }, $gameToAdd[0]->platforms)) : null,

        ];
    }

    public function render()
    {
        return view('livewire.card-game');
    }

}
