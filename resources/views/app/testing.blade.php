<!-- TESTING PAGE -->
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Rilevatore di Codice a Barre</title>
</head>
<body>
    <h1>Carica un'immagine per rilevare il codice a barre</h1>
    <input type="file" id="fileInput" accept="image/*">
    <canvas id="canvas" style="display:none;"></canvas>
    <h3>barcode:</h3>
    <p id="result"></p>

    <!-- Includi ZXing -->
    <script src="https://cdn.jsdelivr.net/npm/@zxing/library@latest"></script>

    <script>
        // Funzione per leggere e rilevare il codice a barre
        function decodeBarcodeFromImage(image) {
            const codeReader = new ZXing.BrowserBarcodeReader();
            const canvas = document.getElementById('canvas');
            const ctx = canvas.getContext('2d');

            // Imposta le dimensioni del canvas
            canvas.width = image.width;
            canvas.height = image.height;

            // Disegna l'immagine sul canvas
            ctx.drawImage(image, 0, 0);

            // Rileva il codice a barre
            codeReader.decodeFromImage(undefined, canvas)
                .then(result => {
                    console.log('Codice scansionato:', result.text);
                    document.getElementById('result').textContent = 'Codice a barre rilevato: ' + result.text;
                })
                .catch(err => {
                    console.error('Errore durante la scansione:', err);
                    document.getElementById('result').textContent = 'Errore nella scansione: ' + err.message;
                });
        }

        // Gestione dell'input file
        document.getElementById('fileInput').addEventListener('change', (event) => {
            const file = event.target.files[0];
            if (file) {
                const reader = new FileReader();
                reader.onload = (e) => {
                    const img = new Image();
                    img.onload = () => decodeBarcodeFromImage(img);
                    img.onerror = (err) => {
                        console.error('Errore durante il caricamento dell\'immagine:', err);
                        document.getElementById('result').textContent = 'Errore durante il caricamento dell\'immagine: ' + err.message;
                    };
                    img.src = e.target.result;
                };
                reader.onerror = (err) => {
                    console.error('Errore durante la lettura del file:', err);
                    document.getElementById('result').textContent = 'Errore durante la lettura del file: ' + err.message;
                };
                reader.readAsDataURL(file);
            } else {
                document.getElementById('result').textContent = 'Nessun file selezionato.';
            }
        });
    </script>
</body>
</html>
