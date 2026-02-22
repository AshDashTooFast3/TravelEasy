<x-guest-layout>
    <form method="POST" action="{{ route('register') }}">
        @csrf

        <!-- Gebruikersnaam -->
        <div>
            <x-input-label for="Gebruikersnaam" :value="__('Gebruikersnaam')" />
            <x-text-input id="Gebruikersnaam" class="block mt-1 w-full" type="text" name="Gebruikersnaam" :value="old('Gebruikersnaam')" required autofocus autocomplete="Gebruikersnaam" />
            <x-input-error :messages="$errors->get('Gebruikersnaam')" class="mt-2" />
        </div>

        <!-- Email -->
        <div class="mt-4">
            <x-input-label for="Email" :value="__('Email')" />
            <x-text-input id="Email" class="block mt-1 w-full" type="email" name="Email" :value="old('Email')" required autocomplete="Email" />
            <x-input-error :messages="$errors->get('Email')" class="mt-2" />
        </div>

        <!-- Wachtwoord -->
        <div class="mt-4">
            <x-input-label for="Wachtwoord" :value="__('Wachtwoord')" />
            <x-text-input id="Wachtwoord" class="block mt-1 w-full"
                            type="password"
                            name="Wachtwoord"
                            required autocomplete="new-password" />
            <x-input-error :messages="$errors->get('Wachtwoord')" class="mt-2" />
        </div>

        <!-- Wachtwoord bevestigen -->
        <div class="mt-4">
            <x-input-label for="Wachtwoord_confirmation" :value="__('Bevestig Wachtwoord')" />
            <x-text-input id="Wachtwoord_confirmation" class="block mt-1 w-full"
                            type="password"
                            name="Wachtwoord_confirmation" required autocomplete="new-password" />
            <x-input-error :messages="$errors->get('Wachtwoord_confirmation')" class="mt-2" />
        </div>

        <!-- RolNaam -->
        <div class="mt-4">
            <x-input-label for="RolNaam" :value="__('RolNaam')" />
            <x-text-input id="RolNaam" class="block mt-1 w-full"
                  type="text"
                  name="RolNaam" required autocomplete="RolNaam" />
            <x-input-error :messages="$errors->get('RolNaam')" class="mt-2" />
        </div>

        <div class="flex items-center justify-end mt-4">
            <a class="underline text-sm text-gray-600 dark:text-gray-400 hover:text-gray-900 dark:hover:text-gray-100 rounded-md focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-indigo-500 dark:focus:ring-offset-gray-800" href="{{ route('login') }}">
                {{ __('Already registered?') }}
            </a>

            <x-primary-button class="ms-4">
                {{ __('Register') }}
            </x-primary-button>
        </div>
    </form>
</x-guest-layout>
