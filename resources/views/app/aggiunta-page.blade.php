@extends('layouts.app')

@section('content')
<link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.6.0/css/all.min.css"
    integrity="sha512-Kc323vGBEqzTmouAECnVceyQqyqdsSiqLQISBL29aUW4U/M7pSPA/gEUZQqv1cwx4OnYxTxve5UMg5GT6L4JJg=="
    crossorigin="anonymous" referrerpolicy="no-referrer" />
<div class="container mt-5 bg-white p-4">
    <div class="text-center mb-4 d-flex">
        <img src="{{ asset('storage/logo/logo.png') }}" alt="Logo" class="img-fluid" style="max-width: 180px;">
        <button type="button" class="btn btn-outline-primary mt-3 ms-5" style="height:25%">BUYER <i
                class="fa-solid fa-user"></i></button>
    </div>

    <div class="text-center">
        <div class="text-center fs-1 fw-bold text-primary mt-5 mb-5 ">
            <h1 style="font-size: 2.5rem;">DETTAGLIO <br> ARTICOLO <br> AGGIUNTO <br> CON <br> SUCCESSO <br> <br> <i
                    class="fa-solid fa-check text-success"></i></h1>
        </div>
        <a href="{{route('homepage')}}" class="text-decoration-underline" style="font-size: 1.3rem;"> clicca qui per aggiungerne un altro</a>
    </div>

</div>
@endsection