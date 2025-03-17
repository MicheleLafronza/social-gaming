<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use App\Models\User;

class Game extends Model
{
    protected $fillable = [
        'igdb_id',
        'name',
        'game_state',
        'cover_id',
        'release_date',
    ];

    protected $casts = [
        'screenshots_id' => 'array',
        'platforms' => 'array',
    ];

    public function users()
    {
        return $this->belongsToMany(User::class, 'user_games');
    }

}
