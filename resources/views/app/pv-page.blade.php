@extends('layouts.app')

@section('content')
    <div class="container mt-5">
        <div class="text-center mb-2">
            <img src="{{ asset('storage/logo/logo.png') }}" alt="Logo" class="img-fluid" style="max-width: 230px;">
        </div>
        <form action="{{ route('store-pv') }}" method="POST">
            @csrf
            <div class="mb-3">
                <label for="insegna" class="form-label" style="font-size: 1.8rem;">Scegli Insegna</label>
                <select class="form-select" id="insegna" name="insegna" required style="border: 1px solid #666666; border-radius: 8px; height:50px">
                    <option value="" disabled selected>Seleziona un'opzione</option>
                    <option value="rossetto">Rossetto</option>
                    <option value="galassia">Galassia</option>
                    <option value="bennet">Bennet</option>
                    <option value="coop">Coop</option>
                    <option value="conad">Conad</option>
                    <option value="prix">Prix</option>
                    <option value="eurospin">Eurospin</option>
                    <option value="esselunga">Esselunga</option>
                    <option value="lidl">Lidl</option>
                    <option value="md">MD</option>
                    <option value="carrefour">Carrefour</option>
                    <option value="pam">Pam</option>
                </select>
            </div>
            <div class="mb-3">
                <label for="pv" class="form-label" style="font-size: 1.6rem;">Scegli Punto Vendita</label>
                <input type="text" class="form-control" id="pv" name="pv" placeholder="Inserisci punto vendita" style="border: 1px solid #666666; border-radius: 8px; height:50px" required>
            </div>
            <button type="submit" class="btn btn-primary">Conferma</button>
        </form>
    </div>
@endsection
