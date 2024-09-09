@extends('layouts.app')

@section('content')
<div class="container mt-4">
    <!-- libreria ZXing-js per l'aggiunta dello scanner -->
    <script src="https://cdn.jsdelivr.net/npm/@zxing/library@latest"></script>

    <!-------------------------------------------------------- LOGO TOSANO -->
    <div class="text-center mb-2">
        <img src="{{ asset('storage/logo/logo.png') }}" alt="Logo" class="img-fluid" style="max-width: 230px;">
    </div>

    <!-------------------------------------------------------- FORM DI AGGIUNTA DETTAGLIO -->
    <div class="mx-auto">
        <div class="card-body p-3">
            <h2 class="text-center mb-2 blue_color" style="font-size: 2.5rem;">Aggiungi dettagli prodotto</h2>

            <form action="{{route('store-product')}}" method="POST" enctype="multipart/form-data">
                @csrf

                <!-- Errori di validazione -->
                @if ($errors->any())
                <div class="alert alert-danger">
                    <ul>
                        @foreach ($errors->all() as $error)
                        <li>{{ $error }}</li>
                        @endforeach
                    </ul>
                </div>
                @endif

                <!-- ------------------------------------------BARCODE -->
                <div class="mb-2">
                    <label for="barcode" class="form-label" style="font-size: 1.6rem;">Aggiungi barcode:</label>
                    <div class="input-group">
                        <span class="input-group-text">+</span>
                        <input type="text" class="form-control" id="barcode" name="barcode" placeholder="Inserisci barcode"
                            style="border: 1px solid #666666; border-radius: 0 8px 8px 0; height:50px">
                    </div>
                    <!-- Bottone per attivare lo SCANNER -->
                    <div class="text-center mt-3">
                        <button type="button" id="startScan" class="btn btn-primary" style="font-size: 1.5rem;">Scansiona barcode</button>
                    </div>
                    <!-- Div che contiene il video dello scanner -->
                    <div id="video-container" class="text-center mt-3" style="display:none;">
                        <video id="video" style="width:100%; max-width:400px;"></video>
                        <button type="button" id="stopScan" class="btn btn-danger mt-2">Ferma scanner</button>
                    </div>
                </div>

                <!-- ------------------------------------------AGGIUNGI FOTO -->
                <div class="mb-2">
                    <label for="photo" class="form-label" style="font-size: 1.6rem;">Aggiungi foto:</label>
                    <div class="input-group">
                        <span class="input-group-text">+</span>
                        <input id="photo" class="form-control" name="photo[]" type="file" multiple
                            style="border: 1px solid #666666; border-radius: 0 8px 8px 0; height:50px" required>
                    </div>
                </div>

                <!-- ---------------------------------------------NOTA -->
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

<!-- Script per attivare lo scanner -->

<script>
    // Chiedi accesso alla fotocamera
    navigator.mediaDevices.getUserMedia({ video: true })
        .then(function(stream) {
            console.log('Accesso alla fotocamera concesso');
        })
        .catch(function(err) {
            console.error('Accesso alla fotocamera negato: ', err);
            alert('Per favore concedi l\'accesso alla fotocamera per utilizzare questa funzionalità.');
        });

    const codeReader = new ZXing.BrowserBarcodeReader();
    const videoElement = document.getElementById('video');
    const videoContainer = document.getElementById('video-container');
    const barcodeInput = document.getElementById('barcode');
    const startScanButton = document.getElementById('startScan');
    const stopScanButton = document.getElementById('stopScan');

    // Evento per iniziare la scansione
    startScanButton.addEventListener('click', () => {
        videoContainer.style.display = 'block'; // Mostra il video
        stopScanButton.style.display = 'inline'; // Mostra il pulsante "Ferma scanner"
        startScanButton.style.display = 'none'; // Nasconde il pulsante "Scansiona barcode"

        // Inizia la scansione dal dispositivo video
        codeReader.decodeOnceFromVideoDevice(undefined, videoElement)
            .then(result => {
                console.log('Codice scansionato: ', result.text); // Mostra il risultato in console
                barcodeInput.value = result.text;  // Inserisce il codice scansionato nell'input
                codeReader.reset();  // Ferma lo scanner
                videoContainer.style.display = 'none';  // Nasconde il video
                stopScanButton.style.display = 'none';  // Nasconde il pulsante "Ferma scanner"
                startScanButton.style.display = 'inline'; // Mostra di nuovo il pulsante "Scansiona barcode"
            })
            .catch(err => {
                console.error('Errore durante la scansione: ', err); // Mostra l'errore in console
                alert('Errore durante la scansione: ' + err); // Notifica visiva dell'errore
            });
    });

    // Evento per fermare la scansione
    stopScanButton.addEventListener('click', () => {
        codeReader.reset();  // Ferma lo scanner
        videoContainer.style.display = 'none';  // Nasconde il video
        stopScanButton.style.display = 'none';  // Nasconde il pulsante "Ferma scanner"
        startScanButton.style.display = 'inline'; // Mostra di nuovo il pulsante "Scansiona barcode"
    });
</script>

@endsection
