@extends('layouts.app')

@section('content')
<div class="container mt-4">
    <!-------------------------------------------------------- LOGO TOSANO -->
    <div class="text-center mb-2">
        <img src="{{ asset('storage/logo/logo.png') }}" alt="Logo" class="img-fluid" style="max-width: 230px;">
    </div>

    <!-------------------------------------------------------- FORM DI AGGIUNTA DETTAGLIO -->
    <div class="mx-auto">
        <div class="card-body p-3">
            <h2 class="text-center mb-2 blue_color" style="font-size: 2.5rem;">Aggiungi dettagli prodotto</h2>

            <form action="{{ route('store-product') }}" method="POST" enctype="multipart/form-data">
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
                    <label for="barcode" class="form-label d-flex" style="font-size: 1.6rem;">1) Aggiungi barcode:</label>
                    
                    <!-- Input file per la scansione dell'immagine del barcode -->
                    <input type="file" name="ufile" id="ufile">
                    <!-- Campo per inserire il barcode tramite Quagga -->
                    <input 
                        type="text" 
                        class="form-control" 
                        id="x" 
                        name="barcode"
                        placeholder="Inserisci barcode"
                        style="border: 1px solid #666666; border-radius: 0 8px 8px 0; height:50px">
                    
                </div>

                <!-- ------------------------------------------AGGIUNGI FOTO -->
                <div class="mb-2">
                    <label for="photo" class="form-label" style="font-size: 1.6rem;">2) Aggiungi foto:</label>
                    <div class="input-group">
                        <input id="photo" class="form-control" name="photo[]" type="file" multiple
                            style="border: 1px solid #666666; border-radius: 0 8px 8px 0; height:50px" required>
                    </div>
                </div>

                <!-----------------------------------------------NOTA -->
                <div class="mb-3">
                    <label for="note" class="form-label" style="font-size: 1.6rem;">3) Aggiungi nota:</label>
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


<script src="https://cdn.jsdelivr.net/npm/@ericblade/quagga2/dist/quagga.min.js"></script>
<script>
    const ufile = document.getElementById('ufile');

    ufile.addEventListener(
        'change',
        (event) => {
            let reader = new FileReader();
            reader.readAsDataURL(ufile.files[0]);

            reader.onload = () => {
                const content = reader.result;

                Quagga.decodeSingle(
                    {
                        src: content,
                        locate: true,
                        decoder: {
                            readers: ["ean_reader"]
                        }
                    },
                    function (result) {
                        if (result.codeResult) {
                            console.log("result", result.codeResult.code);
                            document.getElementById('x').value = result.codeResult.code;
                        } else {
                            console.log("not detected");
                        }
                    }
                )
            }
        }
    );
</script>
@endsection











<!-- <script>

------LIBRERIA QUAGGA-----
    document.getElementById('startScan').addEventListener('click', () => {
        const videoElement = document.getElementById('video');
        const videoContainer = document.getElementById('video-container');
        const barcodeInput = document.getElementById('barcode');
        const stopScanButton = document.getElementById('stopScan');
        const startScanButton = document.getElementById('startScan');

        videoContainer.style.display = 'block'; // Mostra il video
        stopScanButton.style.display = 'inline'; // Mostra il pulsante "Ferma scanner"
        startScanButton.style.display = 'none'; // Nasconde il pulsante "Scansiona barcode"

        Quagga.init({
            inputStream: {
                name: "Live",
                type: "LiveStream",
                target: videoElement, // Elemento video dove viene visualizzata la fotocamera
                constraints: {
                    width: 640,
                    height: 480,
                    facingMode: "environment" // Usa la fotocamera posteriore
                },
            },
            decoder: {
                readers: ["ean_reader", "code_128_reader"] // Specifica i tipi di codici a barre da scansionare
            }
        }, function (err) {
            if (err) {
                console.error(err);
                alert('Errore nell\'inizializzazione di Quagga: ' + err);
                return;
            }
            console.log("Iniziato Quagga con successo");
            Quagga.start();
        });

        Quagga.onProcessed(function (result) {
            const canvas = document.querySelector('canvas'); // Trova la canvas che Quagga usa
            if (canvas) {
                const ctx = canvas.getContext('2d', { willReadFrequently: true }); // Imposta il contesto 2D con willReadFrequently
                console.log("Context impostato con willReadFrequently: true");
            }
        });

        Quagga.onDetected(function (result) {
            console.log('Codice scansionato: ', result.codeResult.code);
            barcodeInput.value = result.codeResult.code;  // Inserisce il codice scansionato nell'input
            Quagga.stop();  // Ferma lo scanner
            videoContainer.style.display = 'none';  // Nasconde il video
            stopScanButton.style.display = 'none';  // Nasconde il pulsante "Ferma scanner"
            startScanButton.style.display = 'inline'; // Mostra di nuovo il pulsante "Scansiona barcode"
        });
    });

    // Evento per fermare la scansione
    document.getElementById('stopScan').addEventListener('click', () => {
        Quagga.stop();  // Ferma lo scanner
        document.getElementById('video-container').style.display = 'none';  // Nasconde il video
        document.getElementById('stopScan').style.display = 'none';  // Nasconde il pulsante "Ferma scanner"
        document.getElementById('startScan').style.display = 'inline'; // Mostra di nuovo il pulsante "Scansiona barcode"
    });

</script>