<?php

namespace App\Services;

use Illuminate\Support\Facades\Cache; // Importa la facciata Cache
use Carbon\Carbon;
use Illuminate\Support\Facades\Http;

class TwitchService
{

    // variabili dell'env
    protected $twitchClientId;
    protected $twitchClientSecret;

    public function __construct() {
        
        // assegno il valore alle variabili dell'env
        $this->twitchClientId = env('TWITCH_CLIENT_ID');
        $this->twitchClientSecret = env('TWITCH_CLIENT_SECRET');

    }

    // recupero il token e l'expire dalla cache
    public function getTwitchToken(): string {

        $twitchAccessToken = Cache::get('twitch_access_token');
        $twitchTokenExpireAt = Cache::get('twitch_token_expire_at');

        // se il token è scaduto lo rigenero
        if (!$twitchAccessToken || !$twitchTokenExpireAt || $twitchTokenExpireAt < Carbon::now())
        {
            return $this->generateTwitchToken();
        };

        return $twitchAccessToken;
    }

    // se non esiste o è scaduto rigenero il token
    private function generateTwitchToken(): string {
            
        // chiamo l'endpoint di twitch per generare il token
        // client_id e client_secret sono le credenziali che ho creato su twitch
            $response = Http::post('https://id.twitch.tv/oauth2/token', [
                'client_id' => $this->twitchClientId,
                'client_secret' => $this->twitchClientSecret,
                'grant_type' => 'client_credentials'
            ]);
    
            $response = json_decode($response->getBody()->getContents());
    
            // salvo il token e l'expire nella cache
            Cache::put('twitch_access_token', $response->access_token, $response->expires_in);
            Cache::put('twitch_token_expire_at', Carbon::now()->addSeconds($response->expires_in));
    
            return $response->access_token;
    }
}