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
                    <label for="barcode" class="form-label d-flex " style="font-size: 1.6rem;">1) Aggiungi
                        barcode:</label>

                    <!-- Campo per inserire il barcode con foto (ean-13) -->
                    <label for="ufile" class="custom-file-upload">
                        Scansiona barcode 
                    </label>
                    <input type="file" name="ufile" id="ufile" style="display: none;">

                    <p class="mt-2">oppure</p>
                    <!-- inserimento manuale del barcode -->
                    <input type="text" class="form-control mt-2" id="x" name="barcode" placeholder="Inserisci barcode"
                        style="border: 1px solid #666666; border-radius: 8px; height:50px">

                </div>

                <!-- ------------------------------------------AGGIUNGI FOTO -->
               
                <div class="mb-2 ">
                <label for="photo" class="form-label d-flex" style="font-size: 1.6rem;">2) Aggiungi foto:</label>
                    <label for="file-input" class="custom-file-upload">
                        Seleziona foto
                    </label>
                    <input id="file-input" class="form-control" name="photo[]" type="file" multiple
                        style="display: none;" required>
                    <ul id="file-list" class="file-list">
                        <li>Nessun file selezionato</li>
                    </ul>
                    <div id="image-preview" class="image-preview"></div>
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

<!-- Libreria utilizzata per la gestione barcode: QUAGGA-->
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

    document.getElementById('file-input').addEventListener('change', function(event) {
        const fileList = document.getElementById('file-list');
        const imagePreview = document.getElementById('image-preview');
        
        fileList.innerHTML = '';  // Pulisce la lista esistente
        imagePreview.innerHTML = '';  // Pulisce l'anteprima delle immagini

        if (this.files.length > 0) {
            for (let i = 0; i < this.files.length; i++) {
                const listItem = document.createElement('li');
                listItem.textContent = this.files[i].name;
                fileList.appendChild(listItem);

                // Creazione di un oggetto URL per visualizzare l'anteprima dell'immagine
                const img = document.createElement('img');
                img.src = URL.createObjectURL(this.files[i]);
                imagePreview.appendChild(img);
            }
        } else {
            const noFileItem = document.createElement('li');
            noFileItem.textContent = 'Nessun file selezionato';
            fileList.appendChild(noFileItem);
        }
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

    .file-name {
        display: block;
        margin-top: 8px;
        font-size: 0.875rem;
        color: #666666;
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