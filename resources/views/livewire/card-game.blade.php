<div class="bg-gray-800 text-white rounded-xl shadow-lg overflow-hidden flex flex-col h-full">
    <!-- Header with Title and Small Cover -->
    <div class="flex items-center p-4 space-x-4">
        <!-- Small Cover Image -->
        @if (isset($game->cover))
        <img src="{{ $game->cover->url }}" alt="Game Cover" class="w-16 h-16 object-scale-down rounded-lg">
        @else
        <div class="w-16 h-16 bg-gray-700 rounded-lg"></div>    
        @endif
        
        <!-- Title -->
        <h2 class="text-xl font-bold">{{ $game->name }}</h2>
    </div>

    <!-- Card Content -->
    <div class="p-4 flex flex-col flex-grow">
        <!-- Platform & Release Date Headers -->
        <div class="grid grid-cols-2 gap-4 text-gray-400 text-sm mb-4">
            <!-- Platforms -->
            <div>
                <h3 class="text-gray-300 font-semibold mb-1">Platforms</h3>
                <ul class="list-disc list-inside text-gray-400 text-sm space-y-1">
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
                <h3 class="text-gray-300 font-semibold mb-1">Release Date</h3>
                @if (isset($game->release_dates[0]->human))
                <span class="text-gray-400 text-sm space-y-1">{{ $game->release_dates[0]->human }}</span>
                @endif
            </div>
        </div>

        <!-- Spacer per allineare il bottone in basso -->
        <div class="flex-grow"></div>

        <!-- Add Button -->
        <button class="w-full cursor-pointer bg-blue-600 hover:bg-blue-700 text-white font-semibold py-2 rounded-lg transition">
            Aggiungi
        </button>
    </div>
</div>




