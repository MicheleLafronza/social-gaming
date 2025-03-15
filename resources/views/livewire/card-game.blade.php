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
        <!-- Publisher & Year -->
        <div class="flex justify-between text-gray-400 text-sm mb-4">
            <span>{{ $game->publisher ?? 'Publisher' }}</span>
            <span>{{ $game->release_year ?? 'Anno' }}</span>
        </div>

        <!-- Spacer per allineare il bottone in basso -->
        <div class="flex-grow"></div>

        <!-- Add Button -->
        <button class="w-full cursor-pointer bg-blue-600 hover:bg-blue-700 text-white font-semibold py-2 rounded-lg transition">
            Aggiungi
        </button>
    </div>
</div>




