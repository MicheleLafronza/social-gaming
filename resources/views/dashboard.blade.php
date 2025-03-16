{{-- <x-layouts.app :title="__('Dashboard')">
    <div class="flex h-full w-full flex-1 flex-col gap-4 rounded-xl">
        <div class="grid auto-rows-min gap-4 md:grid-cols-3">
            <div class="relative aspect-video overflow-hidden rounded-xl border border-neutral-200 dark:border-neutral-700">
                <x-placeholder-pattern class="absolute inset-0 size-full stroke-gray-900/20 dark:stroke-neutral-100/20" />
            </div>
            <div class="relative aspect-video overflow-hidden rounded-xl border border-neutral-200 dark:border-neutral-700">
                <x-placeholder-pattern class="absolute inset-0 size-full stroke-gray-900/20 dark:stroke-neutral-100/20" />
            </div>
            <div class="relative aspect-video overflow-hidden rounded-xl border border-neutral-200 dark:border-neutral-700">
                <x-placeholder-pattern class="absolute inset-0 size-full stroke-gray-900/20 dark:stroke-neutral-100/20" />
            </div>
        </div>
        <div class="relative h-full flex-1 overflow-hidden rounded-xl border border-neutral-200 dark:border-neutral-700">
            <x-placeholder-pattern class="absolute inset-0 size-full stroke-gray-900/20 dark:stroke-neutral-100/20" />
        </div>
    </div>
</x-layouts.app> --}}



{{-- TEST OUT  --}}

<x-layouts.app :title="__('Bacheca')">
    <div class="flex h-full w-full flex-1 flex-col gap-4 rounded-xl">
        <div class="flex flex-row gap-4 justify-between">
            <div class="min-h-[200px] min-w-[200px] rounded-xl overflow-hidden border border-neutral-200 dark:border-neutral-700 p-4">
                <flux:heading size="lg">{{ __('Giochi a cui stai giocando') }}</flux:heading>
                <flux:subheading>{{ __('Attualmente non stai giocando a nessun gioco') }}</flux:subheading>
                <flux:subheading><a href="{{ route('search-game') }}">Aggiungi gioco</a></flux:subheading>
            </div>
            <div class="min-h-[200px] min-w-[200px] bg-sky-700 rounded-xl"></div>
            <div class="min-h-[200px] min-w-[200px] bg-sky-700 rounded-xl"></div>
        </div>
    </div>
</x-layouts.app>
