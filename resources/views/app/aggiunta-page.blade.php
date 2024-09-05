@extends('layouts.app')

@section('content')
<link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.6.0/css/all.min.css"
    integrity="sha512-Kc323vGBEqzTmouAECnVceyQqyqdsSiqLQISBL29aUW4U/M7pSPA/gEUZQqv1cwx4OnYxTxve5UMg5GT6L4JJg=="
    crossorigin="anonymous" referrerpolicy="no-referrer" />
<!-- Bootstrap CSS -->
<link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">

<!-- Bootstrap JS -->
<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"></script>

<div class="container mt-5 bg-white p-4">
    <div class="text-center mb-4 d-flex">
        <img src="{{ asset('storage/logo/logo.png') }}" alt="Logo" class="img-fluid" style="max-width: 180px;">

        <div class="dropdown ms-5 mt-3">
            <button class="btn btn-outline-primary dropdown-toggle" type="button" id="buyerDropdown"
                data-bs-toggle="dropdown" aria-expanded="false" style="height: 100%;">
                BUYER <i class="fa-solid fa-user"></i>
            </button>
            <ul class="dropdown-menu" aria-labelledby="buyerDropdown">
                <li>
                    <!-- attualmente il bottone nel dropdown per il logout è disabilitato per evitare che l'utente possa uscire da account-->
                    <a href="{{ route('logout') }}" class="dropdown-item text-danger disabled"   
                        onclick="event.preventDefault(); document.getElementById('logout-form').submit();">
                        Esci <i class="fa-solid fa-right-from-bracket"></i>
                    </a>
                </li>
            </ul>
        </div>

        <form id="logout-form" action="{{ route('logout') }}" method="POST" style="display: none;">
            @csrf
        </form>
    </div>

    <div class="text-center">
        <div class="text-center fs-1 fw-bold text-primary mt-2 mb-5">
            <h1 style="font-size: 1.5rem;">
                DETTAGLIO ARTICOLO <br> AGGIUNTO CON <br> SUCCESSO <br> 
                <i class="fs-1 fa-solid fa-check text-success mt-2"></i>
            </h1>
        </div>

        <!-- Qui mostriamo i dettagli dell'articolo -->
        <div class="text-center mb-5">
            <p><strong>Barcode:</strong> {{ session('barcode') }}</p>
            <p><strong>Foto:</strong></p>
            <img src="{{ asset('images/' . session('photo')) }}" alt="foto" style="max-width: 290px;"
                class="img-fluid mb-3 ms-4 mt-2">
            <p><strong>Note:</strong> {{ session('note') }}</p>
        </div>

        <a href="{{ route('homepage') }}" class="btn btn-primary" style="font-size: 1.4rem;">
            Aggiungi un altro prodotto
        </a>
    </div>
</div>
@endsection