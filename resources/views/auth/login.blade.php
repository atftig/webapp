<x-guest-layout>
    <!-- Container centrale per il contenuto -->
    <div class="container mx-auto mt-5  p-4 rounded-lg " style="max-width: 400px;">

        <!-- LOGO TOSANO -->
        <div class="text-center">
            <img src="{{ asset('storage/logo/logo.png') }}" alt="Logo" class="mb-4">
        </div>

        <!-- Titolo della pagina -->
        <h1 class="text-center text-primary mb-4">Benvenuto su StockPro</h1>

        <!-- Session Status -->
        <x-auth-session-status class="mb-4" :status="session('status')" />

        <!-- Form di login -->
        <form method="POST" action="{{ route('login') }}">
            @csrf

            <!-- Email Address -->
            <div class="mb-3">
                <x-input-label for="email" :value="__('Nome utente')" />
                <x-text-input id="email" class="block mt-1 w-full" type="email" name="email" :value="old('email')"
                    required autofocus autocomplete="username" placeholder="inserisci nome" />
                <x-input-error :messages="$errors->get('email')" class="mt-2" />
            </div>

            <!-- Password -->
            <div class="mb-3">
                <x-input-label for="password" :value="__('Password')" />
                <x-text-input id="password" class="block mt-1 w-full" type="password" name="password" required
                    autocomplete="current-password" placeholder="inserisci password" />
                <x-input-error :messages="$errors->get('password')" class="mt-2" />
            </div>

            <!-- Pulsante di Login -->
            <div class="text-center mt-4">
                <x-primary-button class="btn btn-primary w-full p-2">
                    {{ __('Accedi') }}
                </x-primary-button>
            </div>
        </form>

        <!-- Testo descrittivo sotto il pulsante -->
        <div class="text-center mt-4">
            <p class="text-xl text-blue-600">
                Il nuovo sistema di gestione efficiente per l'inserimento di prodotti in azienda
            </p>
        </div>

    </div>
</x-guest-layout>