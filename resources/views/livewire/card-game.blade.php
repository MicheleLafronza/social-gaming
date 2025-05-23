<div class="bg-white text-black rounded-xl shadow-lg overflow-hidden flex flex-col h-full">
    <!-- Header with Title and Small Cover -->
    <div class="flex items-center p-4 space-x-4">
        <!-- Small Cover Image -->
        @if (isset($game->cover->image_id))
        <img src="https://images.igdb.com/igdb/image/upload/t_cover_big/{{$game->cover->image_id}}.jpg" alt="Game Cover" class="w-16 h-16 object-contain rounded-lg">
        @else
        <div class="w-16 h-16 bg-gray-700 rounded-lg"></div>    
        @endif
        
        <!-- Title -->
        <h2 class="text-xl font-bold">{{ $game->name }}</h2>
    </div>

    <!-- Card Content -->
    <div class="p-4 flex flex-col flex-grow">
        <!-- Platform & Release Date Headers -->
        <div class="grid grid-cols-2 gap-4 text-sm mb-4">
            <!-- Platforms -->
            <div>
                <h3 class="font-semibold mb-1">Platforms</h3>
                <ul class="list-disc list-inside text-sm space-y-1">
                    @if (isset($game->platforms))
                    @foreach ($game->platforms as $platform)
                        @if (isset($platform->abbreviation))
                        <li>{{ $platform->abbreviation }}</li>
                        @endif
                    @endforeach
                    @endif
                </ul>
            </div>

            <!-- Release Dates -->
            <div>
                <h3 class="font-semibold mb-1">Release Date</h3>
                @if (isset($game->release_dates[0]->human))
                <span class="text-sm space-y-1">{{ $game->release_dates[0]->human }}</span>
                @endif
            </div>
        </div>

        <!-- Spacer per allineare il bottone in basso -->
        <div class="flex-grow"></div>

        @if ($canAdd)
        <!-- Modal Trigget solo se canAdd è true -->
        <flux:modal.trigger :name="'add-game-'.$game->id">
            <flux:button variant="primary" class="w-full cursor-pointer font-semibold py-2 rounded-lg transition">Aggiungi gioco</flux:button>
        </flux:modal.trigger>
        @else
        <div class="w-full bg-green-500 text-white text-center font-semibold py-2 rounded-lg">Già presente sul tuo account</div>
        @endif

        <!-- Modal -->
        <flux:modal :name="'add-game-'.$game->id" class="md:w-96">
            <div class="space-y-6 p-6">
                <!-- Immagine di copertina -->
                @if (isset($game->screenshots))
                <img src="https://images.igdb.com/igdb/image/upload/t_screenshot_big/{{ $game->screenshots[0]->image_id }}.jpg" alt="{{ $game->name }}" class="w-full h-32 object-fill rounded-t-lg"">
                @endif
                
                <!-- Titolo e sottotitolo -->
                <div class="text-center">
                    <flux:heading size="lg">Stai per aggiungere <span class="text-gray-900 font-semibold">{{ $game->name }}</span> ai tuoi giochi</flux:heading>
                </div>
                
                <!-- Select con le opzioni -->
                <div>
                    <label for="game-status" class="block text-sm font-medium text-gray-700">Stato del gioco</label>
                    <select id="game-status" wire:model="gameStatus" class="mt-1 block w-full px-3 py-2 border border-gray-300 rounded-md shadow-sm focus:outline-none focus:ring-primary focus:border-primary">
                        <option value="completed">Completato</option>
                        <option value="playing">Lo sto giocando adesso</option>
                        <option value="interested">Mi interessa</option>
                    </select>
                </div>
                
                <!-- Pulsante di azione -->
                <div class="flex justify-end">
                    <flux:button wire:click="addGame" variant="primary">Aggiungi</flux:button>
                </div>

                <div wire:loading> 
                    Sto aggiungengo il gioco..
                </div>

                @if ($errors->any())
                    <div class="bg-red-500 text-white p-2 rounded-md mb-4">
                        <ul>
                        @foreach ($errors->all() as $error)
                            <li>{{ $error }}</li>
                        @endforeach
                        </ul>
                    </div>
                @endif
            </div>
        </flux:modal>
    </div>
</div>




