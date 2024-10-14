@extends('layouts.app')

@section('content')
<link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.6.0/css/all.min.css"
    integrity="sha512-Kc323vGBEqzTmouAECnVceyQqyqdsSiqLQISBL29aUW4U/M7pSPA/gEUZQqv1cwx4OnYxTxve5UMg5GT6L4JJg=="
    crossorigin="anonymous" referrerpolicy="no-referrer" />
<!-- Bootstrap CSS -->
<link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">

<!-- Bootstrap JS -->
<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"></script>

<div class="container-fluid mt-3 bg-white p-3">
    <div class="text-center mb-4">
        <div class="justify-content-center align-items-center">
            <!-- <a href="{{route('pv-page')}}">
                <img src="{{ asset('storage/logo/logo.png') }}" alt="Logo" class="img-fluid" style="max-width: 150px;">
            </a> -->

            <div class="text-center mb-2">
                <a href="{{route('pv-page')}}">
                    <button style="text-decoration: underline; color: #D32F2F; font-size: 1.3rem;">Clicca qui per tornare alla scelta
                        dell'insegna</button>
                </a>
            </div>

            <!-- <div class="dropdown ms-4">
                <button class="btn btn-outline-primary dropdown-toggle" type="button" id="buyerDropdown"
                    data-bs-toggle="dropdown" aria-expanded="false">
                    BUYER <i class="fa-solid fa-user"></i>
                </button>
                <------------------------------------------------------- LOGOUT DISABLED----------------------->
                <!-- <ul class="dropdown-menu" aria-labelledby="buyerDropdown">
                    <li>
                        <a href="{{ route('logout') }}" class="dropdown-item text-danger"
                            onclick="event.preventDefault(); document.getElementById('logout-form').submit();">
                            Esci <i class="fa-solid fa-right-from-bracket"></i>
                        </a>
                    </li>
                </ul>
            </div> -->
            <!--------------------------------------------------------- /LOGOUT DISABLED----------------------->
            <!-- <form id="logout-form" action="{{ route('logout') }}" method="POST" style="display: none;">
                @csrf
            </form> -->
        </div>
    </div>

    <div class="text-center mb-5">
        <h1 class="h4 fw-bold text-primary mb-4">
            Dettaglio ISPEZIONE aggiunto con successo <br>
            <i class="fa-solid fa-check text-success mt-3" style="font-size: 2rem;"></i>
        </h1>

        <!-- Mostriamo i dettagli dell'articolo -->
        <div class="text-center mb-4">
            <h3 class="fw-bold">Barcode:</h3>
            <p>{{ $barcode }}</p>

            <!-- prezzo del prodotto -->
            <h3 class="fw-bold">Prezzo € :</h3>
            <div class="row g-2 justify-content-center">
                <p>{{ $prezzo}}</p>
            </div>

            <!-- isset = if set = se note è settato lo mette, se invece è null no (messa in alternativa al commento-->
            @isset($note)
                <h3 class="fw-bold">Note:</h3>
                <p>{{ $note }}</p>
            @endisset

            <a href="{{route('homepage-ispettori')}}" class="btn btn-primary" style="font-size: 1.4rem; padding: 1rem;">
                Aggiungi un altro prodotto
            </a>
        </div>
    </div>
    @endsection