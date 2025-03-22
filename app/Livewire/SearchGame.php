<?php

namespace App\Livewire;

use Livewire\Component;
use App\Services\TwitchService;
use Illuminate\Support\Facades\Http;
use Illuminate\Support\Facades\Cache;
use Carbon\Carbon;

class SearchGame extends Component
{
    public $gameName = '';
    public $games = [];
    public $emptyGames = false;

    public function submitGameName()
    {
        $this->games = [];
        $this->emptyGames = false;
        $twitchService = app(TwitchService::class);
        $twitchAccessToken = $twitchService->getTwitchToken();
            
        $twitchClientId = env('TWITCH_CLIENT_ID');
            
        $response = Http::withHeaders([
            'Client-ID' => $twitchClientId,
            'Authorization' => 'Bearer ' . $twitchAccessToken,
        ])
        ->withBody("
            fields name, cover.image_id, platforms.abbreviation, release_dates.human, screenshots.image_id;
            search \"$this->gameName\";
        ", 'text/plain')
        ->post('https://api.igdb.com/v4/games');
        
        $this->games = json_decode($response->getBody()->getContents());

        
        
        // Verifica se ci sono giochi trovati
        if (count($this->games) > 0) {
            return $this->games;
        } else {
            return $this->emptyGames = true;
        }   
    }

    public function render()
    {
        return view('livewire.search-game');
    }
}
