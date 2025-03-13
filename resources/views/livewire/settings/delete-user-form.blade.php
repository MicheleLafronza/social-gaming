<?php

use App\Livewire\Actions\Logout;
use Illuminate\Support\Facades\Auth;
use Livewire\Volt\Component;

new class extends Component {
    public string $password = '';

    /**
     * Delete the currently authenticated user.
     */
    public function deleteUser(Logout $logout): void
    {
        $this->validate([
            'password' => ['required', 'string', 'current_password'],
        ]);

        tap(Auth::user(), $logout(...))->delete();

        $this->redirect('/', navigate: true);
    }
}; ?>

<section class="mt-10 space-y-6">
    <div class="relative mb-5">
        <flux:heading>{{ __('Cancella account') }}</flux:heading>
        <flux:subheading>{{ __('Cancella il tuo account tutte le info e i dati') }}</flux:subheading>
    </div>

    <flux:modal.trigger name="confirm-user-deletion">
        <flux:button variant="danger" x-data="" x-on:click.prevent="$dispatch('open-modal', 'confirm-user-deletion')">
            {{ __('Cancella Account') }}
        </flux:button>
    </flux:modal.trigger>

    <flux:modal name="confirm-user-deletion" :show="$errors->isNotEmpty()" focusable class="max-w-lg">
        <form wire:submit="deleteUser" class="space-y-6">
            <div>
                <flux:heading size="lg">{{ __('Sei sicuro di cancellare il tuo account?') }}</flux:heading>

                <flux:subheading>
                    {{ __('Se il tuo account viene cancellato tutti i tuoi dati e le tue risorse saranno perse permanentemente. Per favore inserisci la tua password per confermare la cancellazione permanente del tuo account.') }}
                </flux:subheading>
            </div>

            <flux:input wire:model="password" :label="__('Password')" type="password" />

            <div class="flex justify-end space-x-2">
                <flux:modal.close>
                    <flux:button variant="filled">{{ __('Annulla') }}</flux:button>
                </flux:modal.close>

                <flux:button variant="danger" type="submit">{{ __('Cancella Account') }}</flux:button>
            </div>
        </form>
    </flux:modal>
</section>
