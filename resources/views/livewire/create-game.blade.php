<div>
    <flux:input wire:model="gameName" label="Titolo del gioco" description="Per iniziare inserisci il titolo del gioco" />
    <flux:button wire:click="submitGameName" class="mt-4">Cerca gioco</flux:button>

    @if (count($games) > 0)
    <div class="grid grid-cols-1 sm:grid-cols-2 md:grid-cols-3 gap-6 p-4">
        @foreach ($games as $game)
            <livewire:card-game :game="$game" :key="$game->id" />
        @endforeach
    </div>
        
    @endif
</div>
