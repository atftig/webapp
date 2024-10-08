<x-guest-layout>
        <!-- Font Awesome -->
        <link href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0-beta3/css/all.min.css" rel="stylesheet">
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

            <!-- Pulsante di Login -->
        </form>

        <!-- alert errore autenticazione -->
        <h2 class="text-center" style="font-size: 1.5rem; color: #D32F2F;">NOME UTENTE O PASSWORD ERRATI. </h2>
        <h2 class="text-center mt-4" style="font-size: 1.5rem"> <i class="fa-solid fa-arrow-down"></i> RITENTA <i class="fa-solid fa-arrow-down"></i></h2>
        
        <div class="text-center mt-4">
        <a href="{{route('login')}}">
                <x-primary-button style="text-decoration: underline; color: blue ;" style="background-color: #D32F2F; border-radius: 8px; height: 3rem; font-size: 1.2rem;">Torna al login</x-primary-button>
            </a>
        </div>


        <!-- Testo descrittivo sotto il pulsante -->
        <!-- <div class="text-center mt-5 text-primary">
            <p class="text-xl">
                Il nuovo sistema di gestione efficiente per l'inserimento di prodotti in azienda
            </p>
        </div> -->

    </div>
</x-guest-layout>