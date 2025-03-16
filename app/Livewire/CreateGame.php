<?php

namespace App\Livewire;

use Livewire\Component;
use App\Services\TwitchService;
use Illuminate\Support\Facades\Http;
use Illuminate\Support\Facades\Cache;
use Carbon\Carbon;

class CreateGame extends Component
{
    public $gameName = '';
    public $games = [];

    public function submitGameName(): array 
    {
        $this->games = [];
        $twitchService = app(TwitchService::class);
        $twitchAccessToken = $twitchService->getTwitchToken();
            
        $twitchClientId = env('TWITCH_CLIENT_ID');
            
        $response = Http::withHeaders([
            'Client-ID' => $twitchClientId,
            'Authorization' => 'Bearer ' . $twitchAccessToken,
        ])
        ->get('https://api.igdb.com/v4/games', [
            'fields' => 'name, cover.url, platforms.abbreviation, release_dates.human',
            'search' => $this->gameName,
        ]);
        $this->games = json_decode($response->getBody()->getContents());
        // dd($this->games);
        return $this->games;
            
    }

    public function render()
    {
        return view('livewire.create-game');
    }
}
