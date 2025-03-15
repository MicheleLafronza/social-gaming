<?php

namespace App\Livewire;

use Livewire\Component;

class CardGame extends Component
{
    public $game;

    public function render()
    {
        return view('livewire.card-game');
    }
}
