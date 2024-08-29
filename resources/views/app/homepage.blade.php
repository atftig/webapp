<!-- <div>
    <h1>Ciao mondo</h1>
</div> -->

@extends('layouts.app')

@section('content')
<div class="container mt-5 bg-white">
    
    <!-- LOGO TOSANO -->

    <div class="text-center">
        <img src="{{ asset('storage/logo/logo.png') }}" alt="Logo" class="mb-4">
    </div>


    <!-- FORM DI AGGIUNTA DETTAGLIO -->
    <div class=" p-4">
        <h2 class="text-center mb-4">Aggiungi dettagli prodotto</h2>

        <form>
            <!-- BARCODE -->
            <div class="mb-3">
                <label for="barcode" class="form-label">Aggiungi barcode:</label>
                <div class="input-group">
                    <span class="input-group-text">+</span>
                    <input type="text" class="form-control" id="barcode" placeholder="Inserisci barcode">
                </div>
            </div>

            <!--AGGIUNGI FOTO -->
            <div class="mb-3">
                <label for="photo" class="form-label">Aggiungi foto:</label>
                <div class="input-group">
                    <span class="input-group-text">+</span>
                    <input type="file" class="form-control" id="photo">
                </div>
            </div>

            <!-- NOTA -->
            <div class="mb-3">
                <label for="note" class="form-label">Aggiungi nota:</label>
                <textarea class="form-control" id="note" rows="3"
                    placeholder="Inserisci note riguardanti il prodotto, consigli posizionamento ecc."></textarea>
            </div>

            <!-- BOTTONE DI INVIO -->
            <div class="d-grid">
                <button type="submit" class="btn btn-danger">Carica</button>
            </div>
        </form>
    </div>
</div>
@endsection