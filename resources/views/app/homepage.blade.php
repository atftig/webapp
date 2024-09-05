<!-- <div>
    <h1>Ciao mondo</h1>
</div> -->

<!-- ----------------------------------------------------------HOME PAGE PER AGGIUNTA BARCODE, FOTO, NOTE -->
@extends('layouts.app')

@section('content')
<div class="container mt-4">

<!-------------------------------------------------------- LOGO TOSANO -->
    <div class="text-center mb-2">
        <!-- se attivo questo cliccando su qualsiasi zona dello schemo mi porta alla dashboard -->
        <!-- <a href="{{ route('dashboard') }}"> -->
            <img src="{{ asset('storage/logo/logo.png') }}" alt="Logo" class="img-fluid" style="max-width: 230px;">
    </div>

<!-------------------------------------------------------- FORM DI AGGIUNTA DETTAGLIO -->
    <div class="mx-auto">
        <div class="card-body p-3">
            <h2 class="text-center mb-2 blue_color" style="font-size: 2.5rem;">Aggiungi dettagli prodotto</h2>

            <form action="{{route('store-product')}}" method="POST" enctype="multipart/form-data">
                @csrf
<!-- ------------------------------------------BARCODE -->
                @if ($errors->any())
                    <div class="alert alert-danger">
                        <ul>
                            @foreach ($errors->all() as $error)
                                <li>{{ $error }}</li>
                            @endforeach
                        </ul>
                    </div>
                @endif

                <div class="mb-2">
                    <label for="barcode" class="form-label" style="font-size: 1.6rem;">Aggiungi barcode:</label>
                    <div class="input-group">
                        <span class="input-group-text">+</span>
                        <input type="text" class="form-control" id="barcode" name="barcode" placeholder="Inserisci barcode"
                            style="border: 1px solid #666666; border-radius: 0 8px 8px 0; height:50px">
                    </div>
                </div>

<!-- ------------------------------------------AGGIUNGI FOTO -->
                <div class="mb-2">
                    <label for="photo" class="form-label" style="font-size: 1.6rem;">Aggiungi foto:</label>
                    <div class="input-group">
                        <span class="input-group-text">+</span>
                        <input 
                        id="photo" 
                        class="form-control" 
                        name="photo" 
                        type="file" 
                        multiple
                        style="border: 1px solid #666666; border-radius: 0 8px 8px 0; height:50px" 
                        required>
                    </div>
                </div>

<!---------------------------------------------NOTA -->
                <div class="mb-3">
                    <label for="note" class="form-label" style="font-size: 1.6rem;">Aggiungi nota:</label>
                    <textarea class="form-control" id="note" name="note" rows="5"
                        placeholder="Inserisci note riguardanti il prodotto, consigli posizionamento ecc."
                        style="border-radius: 8px; border: 1px solid #666666;"></textarea>
                </div>

<!-- ------------------------------------------BOTTONE DI INVIO -->
                <div class="d-grid">
                    <button type="submit" class="btn btn-danger"
                        style="background-color: #D32F2F; border-radius: 8px; height: 5rem; font-size: 2rem;">Carica</button>
                        
                </div>
            </form>
        </div>
    </div>
</div>
@endsection