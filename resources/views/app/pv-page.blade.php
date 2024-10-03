@extends('layouts.app')

@section('content')
    <div class="container mt-5">
        <form action="{{ route('store-pv') }}" method="POST">
            @csrf
            <div class="mb-3">
                <label for="insegna" class="form-label">Scegli Insegna</label>
                <select class="form-select" id="insegna" name="insegna" required>
                    <option value="" disabled selected>Seleziona un'opzione</option>
                    <option value="rossetto">Rossetto</option>
                    <option value="galassia">Galassia</option>
                    <option value="coop">Coop</option>
                    <option value="codan">Conad</option>
                    <option value="prix">Prix</option>
                    <option value="eurospin">Eurospin</option>
                </select>
            </div>
            <div class="mb-3">
                <label for="puntoVendita" class="form-label">Scegli Punto Vendita</label>
                <input type="text" class="form-control" id="pv" name="pv" placeholder="Inserisci punto vendita" required>
            </div>
            <button type="submit" class="btn btn-primary">Conferma</button>
        </form>
    </div>
@endsection
