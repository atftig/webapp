@extends('layouts.app')

@section('content')

<div class="container mt-4">
    <!-------------------------------------------------------- LOGO -->
    <div class="text-center mb-2">
        <a href="{{route('pv-page')}}">
            <button style="text-decoration: underline; color: #D32F2F;">clicca qui per tornare alla scelta
                dell'insegna</button>
            <!-- <img src="{{ asset('storage/logo/logo.png') }}" alt="Logo" class="img-fluid" style="max-width: 230px;"> -->
        </a>
    </div>

    <!-------------------------------------------------------- FORM DI AGGIUNTA DETTAGLIO -->
    <div class="mx-auto">
        <div class="card-body p-3">



            <!-- Mostriamo i dettagli dell'articolo -->
            <div class="text-center mb-4">
                <h2 class="fw-bold">Insegna:</h2>
                <p>{{ session('insegna') }}</p>

                <!-- prezzo del prodotto -->
                <h2 class="fw-bold">Punto Vendita:</h2>
                <div class="row g-2 justify-content-center">
                    <p>{{ session('pv')}}</p>
                </div>
            </div>

            <h2 class="text-center mb-2 blue_color" style="font-size: 2.5rem;">Aggiungi dettagli ispezione</h2>

            <form action="{{ route('store-ispettore') }}" method="POST" enctype="multipart/form-data">
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
                    <label for="barcode" class="form-label d-flex" style="font-size: 1.6rem;">1) Aggiungi
                        barcode:</label>

                    <!-- Campo per inserire il barcode con foto (ean-13) -->
                    <label for="ufile" class="custom-file-upload">
                        Scansiona barcode
                    </label>
                    <input type="file" name="ufile" id="ufile" style="display: none;">

                    <p class="mt-2">oppure</p>
                    <!-- inserimento manuale del barcode -->
                    <input type="text" class="form-control mt-2" id="x" name="barcode"
                        placeholder="Inserisci barcode manualmente"
                        style="border: 1px solid #666666; border-radius: 8px; height:50px" required>
                </div>


                <!-----------------------------------------------PREZZO -->
                <div class="mb-3">
                    <label for="prezzo" class="form-label" style="font-size: 1.6rem;">2) Aggiungi prezzo:</label>
                    <input type="text" class="form-control" id="prezzo" name="prezzo" rows="5"
                        placeholder="Inserisci prezzo" style="border-radius: 8px; border: 1px solid #666666;"></i>
                </div>

                <!-- ------------------------------------------BOTTONE DI INVIO -->
                <div class="d-grid">
                    <button type="submit" class="btn btn-danger mb-5"
                        style="background-color: #D32F2F; border-radius: 8px; height: 5rem; font-size: 2rem;">Carica</button>
                </div>


                <!-- ------------------------------------------AGGIUNGI FOTO -->
                <!-- <div id="file-inputs-container">
                    <div class="mb-2 ">
                    <label for="foto" class="form-label d-flex" style="font-size: 2rem;">Vuoi aggiungere altro?</label>
                        <label for="foto" class="form-label d-flex" style="font-size: 1.6rem;">3) Aggiungi foto:</label>
                        <label for="file-input-1" class="custom-file-upload">
                            Seleziona/scatta foto
                        </label>
                        <input id="file-input-1" class="form-control" name="foto[]" type="file" style="display: none;">
                        <ul id="file-list-1" class="file-list">
                            <li>Nessun file selezionato</li>
                        </ul>
                        <div id="image-preview-1" class="image-preview"></div>
                    </div>
                </div> -->

                <!-----------------------------------------------NOTE -->
                <!-- <div class="mb-3">
                    <label for="note" class="form-label" style="font-size: 1.6rem;">4) Aggiungi note:</label>
                    <textarea class="form-control" id="note" name="note" rows="5"
                        placeholder="Inserisci note"
                        style="border-radius: 8px; border: 1px solid #666666;"></textarea>
                </div> -->
            </form>
        </div>
    </div>
</div>

<!-- Libreria utilizzata per la gestione barcode: QUAGGA -->
<script src="https://cdn.jsdelivr.net/npm/@ericblade/quagga2/dist/quagga.min.js"></script>
<script>
    // Gestione del barcode scanner
    const ufile = document.getElementById('ufile');
    ufile.addEventListener('change', function (event) {
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
    });

    // Funzione per aggiornare la lista di file selezionati e l'anteprima delle immagini
    function updateFileList(event, counter) {
        const fileList = event.target.files;
        const fileListContainer = document.getElementById(`file-list-${counter}`);
        const imagePreviewContainer = document.getElementById(`image-preview-${counter}`);

        fileListContainer.innerHTML = '';  // Pulisce la lista precedente
        imagePreviewContainer.innerHTML = '';  // Pulisce l'anteprima delle immagini

        if (fileList.length === 0) {
            fileListContainer.innerHTML = '<li>Nessun file selezionato</li>';
        } else {
            for (let i = 0; i < fileList.length; i++) {
                const li = document.createElement('li');
                li.textContent = fileList[i].name;
                fileListContainer.appendChild(li);

                //             // Creazione di un oggetto URL per visualizzare l'anteprima dell'immagine
                const img = document.createElement('img');
                img.src = URL.createObjectURL(fileList[i]);
                img.style.width = '100px';  // Imposta la dimensione dell'anteprima
                img.style.height = '100px';
                imagePreviewContainer.appendChild(img);
            }
        }
    }

    // // Gestione del primo input per le foto
    document.getElementById('file-input-1').addEventListener('change', function (event) {
        updateFileList(event, 1);

        //     // Mostra il pulsante per aggiungere un'altra foto dopo aver selezionato la prima
        document.getElementById('add-photo-container').style.display = 'block';
    });

    // // Gestione del pulsante per aggiungere un'altra foto
    document.getElementById('add-photo-btn').addEventListener('click', function () {
        const newCounter = document.querySelectorAll('[id^=file-input-]').length + 1;

        let newInputDiv = document.createElement('div');
        newInputDiv.classList.add('mb-2');
        newInputDiv.id = `photo-input-${newCounter}`;

        newInputDiv.innerHTML = `
            <label for="file-input-${newCounter}" class="form-label d-flex" style="font-size: 1.6rem;">Aggiungi foto:</label>
            <label for="file-input-${newCounter}" class="custom-file-upload">
                Seleziona/scatta foto
            </label>
            <input id="file-input-${newCounter}" class="form-control" name="photo[]" type="file" style="display: none;">
            <ul id="file-list-${newCounter}" class="file-list">
                <li>Nessun file selezionato</li>
            </ul>
            <div id="image-preview-${newCounter}" class="image-preview"></div>
        `;

        document.getElementById('file-inputs-container').appendChild(newInputDiv);

        //     // Aggiungi l'evento per il nuovo input
        let fileInput = document.getElementById(`file-input-${newCounter}`);
        fileInput.addEventListener('change', function (event) {
            updateFileList(event, newCounter);
        });
    });
</script>

<style>
    .custom-file-upload {
        display: inline-block;
        padding: 8px 20px;
        cursor: pointer;
        border: 1px solid #666666;
        border-radius: 8px;
        background-color: #f1f1f1;
        height: 50px;
        line-height: 30px;
        text-align: center;
        font-size: 1rem;
    }

    .custom-file-upload:hover {
        background-color: #e0e0e0;
    }

    .file-list {
        margin-top: 8px;
        font-size: 0.875rem;
        color: #666666;
        list-style-type: none;
        padding-left: 0;
    }

    .file-list li {
        margin-bottom: 5px;
    }

    .image-preview {
        margin-top: 10px;
        display: flex;
        flex-wrap: wrap;
        gap: 10px;
    }

    .image-preview img {
        max-width: 150px;
        max-height: 150px;
        object-fit: cover;
        border: 1px solid #ddd;
        border-radius: 8px;
    }
</style>
@endsection