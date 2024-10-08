<x-guest-layout>
    <!-- Container centrale per il contenuto -->
    <div class="container mx-auto mt-5  p-4 rounded-lg " style="max-width: 400px;">

        <!-- LOGO -->
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

            <!-- Nome -->
            <div class="mb-3">
                <x-input-label style="font-size: 1.5rem;" for="name" :value="__('Nome utente')" />
                <x-text-input style="height:50px" id="name" class="block mt-3 mb-4 w-full" type="text" name="name"
                    :value="old('name')" required autofocus autocomplete="username"
                    placeholder="Inserisci nome utente" />
                <x-input-error :messages="$errors->get('name')" class="mt-2" />
            </div>

            <!-- Password -->
            <div class="mb-3">
                <x-input-label style="font-size: 1.5rem;" for="password" :value="__('Password')" />
                <x-text-input style="height:50px" id="password" class="block mt-3 mb-4 w-full" type="password"
                    name="password" required autocomplete="current-password" placeholder="Inserisci password" />
                <x-input-error :messages="$errors->get('password')" class="mt-2" />
            </div>

            <!-- Pulsante di Login -->
            <div class="text-center mt-4">
                <x-primary-button class="btn btn-danger mt-4"
                    style="background-color: #D32F2F; border-radius: 8px; height: 3rem; font-size: 2rem;">
                    {{ __('Accedi') }}
                </x-primary-button>
            </div>
        </form>



        <!-- Testo descrittivo sotto il pulsante -->
        <div class="text-center mt-5 text-primary">
            <p class="text-xl">
                Il nuovo sistema di gestione efficiente per l'inserimento di prodotti in azienda
            </p>
        </div>

    </div>
</x-guest-layout>
