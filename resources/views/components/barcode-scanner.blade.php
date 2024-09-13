<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>ZXing Example</title>
</head>

<body>
    <input type="file" name="ufile" id="ufile">
    <form action="" method="get">
        <input 
        type="text" 
        class="form-control"
        id="x"
        name="x"
        placeholder="Inserisci barcode"
        style="border: 1px solid #666666; border-radius: 0 8px 8px 0; height:50px">
    </form>

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
                    // console.log(content)
                    // return;

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
                                document.getElementById('x').value = result.codeResult.code
                            } else {
                                console.log("not detected");
                            }
                        }
                    )
                }
            }
        );
    </script>
</body>

</html>