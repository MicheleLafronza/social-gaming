<div class="w-full flex flex-col justify-center items-center gap-2">

    {{-- sezione di ricerca --}}
    <div class="bg-white rounded-xl w-3/5 p-4">
        <div class="flex flex-col items-center p-4 text-center justify-center">
            <flux:input class="w-3/5" wire:keydown.enter="submitGameName" wire:model="gameName" label="Cerca il titolo del gioco" description="inserisci il titolo del gioco" placeholder="Metal Gear..." />
            <flux:button wire:click="submitGameName" class="mt-4">Cerca gioco</flux:button>
        </div>
    </div>

    @if (count($games) > 0)
    <div class="grid grid-cols-1 sm:grid-cols-2 md:grid-cols-3 gap-6 p-4">
        @foreach ($games as $game)
            <livewire:card-game :game="$game" :key="$game->id" />
        @endforeach
    </div>
    @elseif ($emptyGames)
    <div class="bg-white rounded-xl p-4 text-center w-3/5">
        <p class="text-lg font-bold">Nessun gioco trovato!</p>
        <p class="text-sm text-gray-500">Prova a cercare un altro gioco!</p>
    </div>
    @endif
    
    <!-- Mostra il messaggio di successo -->
    @if (session()->has('message'))
    <div class="bg-white rounded-xl p-4 text-center w-3/5">
        <p class="text-lg font-bold">{{ session('message') }}</p>
    </div>
    @endif
    
</div>
