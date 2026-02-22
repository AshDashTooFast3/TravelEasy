<x-guest-layout>
    <form method="POST" action="{{ route('password.store') }}">
        @csrf

        <!-- Password Reset Token -->
        <input type="hidden" name="token" value="{{ $request->route('token') }}">

        <!-- Email Address -->
        <div>
            <x-input-label for="Email" :value="__('Email')" />
            <x-text-input id="Email" class="block mt-1 w-full" type="email" name="Email" :value="old('Email', $request->Email)" required autofocus autocomplete="username" />
            <x-input-error :messages="$errors->get('Email')" class="mt-2" />
        </div>

        <!-- Password -->
        <div class="mt-4">
            <x-input-label for="Wachtwoord" :value="__('Wachtwoord')" />
            <x-text-input id="Wachtwoord" class="block mt-1 w-full" type="password" name="Wachtwoord" required autocomplete="new-password" />
            <x-input-error :messages="$errors->get('Wachtwoord')" class="mt-2" />
        </div>

        <!-- Confirm Password -->
        <div class="mt-4">
            <x-input-label for="Wachtwoord_confirmation" :value="__('Bevestig Wachtwoord')" />
            <x-text-input id="Wachtwoord_confirmation" class="block mt-1 w-full"
                                type="password"
                                name="Wachtwoord_confirmation" required autocomplete="new-password" />
            <x-input-error :messages="$errors->get('Wachtwoord_confirmation')" class="mt-2" />
        </div>

        <div class="flex items-center justify-end mt-4">
            <x-primary-button>
                {{ __('Reset Wachtwoord') }}
            </x-primary-button>
        </div>
    </form>
</x-guest-layout>
