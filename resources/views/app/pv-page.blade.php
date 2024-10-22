@extends('layouts.app')

@section('content')
<!-- Bootstrap CSS -->
<link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">

<div class="container mt-5">
    <!-- <div class="text-center mb-2">
            <img src="{{ asset('storage/logo/logo.png') }}" alt="Logo" class="img-fluid" style="max-width: 230px;">
        </div> -->
    <form action="{{ route('store-pv') }}" method="POST">
        @csrf
        <div class="mb-3">
        <label for="insegna" class="form-label" style="font-size: 1.8rem;">Scegli Insegna</label>
            <select class="form-select" id="insegna" name="insegna" required
                style="border: 1px solid #666666; border-radius: 8px; height:50px" onchange="toggleInsegnaInput(this)">
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
                <option value="a&o">A&O</option>
                <option value="todis">Todis</option>
                <option value="sisa">Sisa</option>
                <option value="tigros">Tigros</option>
                <option value="aldi">Aldi</option>
                <option value="auchan">Auchan</option>
                <option value="penny">Penny Market</option>
                <option value="despar">Despar</option>
                <option value="famila">Famila</option>
                <option value="poli">Poli</option>
                <option value="martinelli">Martinelli</option>
                <option value="altro">altro...</option>
            </select>

            <p class="mt-2" id="oppure" style="display: none;">oppure</p>

            <input type="text" class="form-control mt-2" id="input-insegna" name="insegna_altro" placeholder="Inserisci insegna"
            style="border: 1px solid #666666; border-radius: 8px; height:50px; display:none;" required>
        </div>

<!--------------------------- punto vendita -->

        <div class="mb-3">
            <label for="pv" class="form-label" style="font-size: 1.6rem;">Scegli Punto Vendita</label>
            <input type="text" class="form-control" id="pv" name="pv" placeholder="Inserisci punto vendita"
                style="border: 1px solid #666666; border-radius: 8px; height:50px" required>
        </div>
        <button type="submit" class="btn btn-primary">Conferma</button>
    </form>
</div>


<script>

function toggleInsegnaInput(select) {
        var input = document.getElementById('input-insegna');
        var oppure = document.getElementById('oppure');
        if (select.value === 'altro') {                 //se clicco altro allora
            input.style.display = 'block';              //si sbloccano l'input e l' "oppure"
            oppure.style.display = 'block';
            input.setAttribute('required', 'required'); // Imposta 'required' quando, cliccando "altro" diventano visibili
            input.focus();                              //focus sul nuovo input che avrà il contorno blu
        } else {                                        //altrimenti se clicco un'insegna
            input.style.display = 'none';               //input e "oppure" sono invisibili
            oppure.style.display = 'none';
            input.removeAttribute('required');          // Rimuovere 'required' quando non visibile
            input.value = '';
        }
    }

</script>

@endsection