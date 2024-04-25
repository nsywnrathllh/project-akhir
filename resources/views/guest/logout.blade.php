@extends('layouts.template-mazer')
@section('content')
    <div class="page-heading">
        <h3>Scan Barcode for Checkout</h3>
    </div>
    <div class="card">
        <div class="card-body">
            <div id="scanner-container"></div>
            <p id="scanned-result"></p>
        </div>
    </div>

    <script src="https://cdnjs.cloudflare.com/ajax/libs/quagga/0.12.1/quagga.min.js"></script>
    <script>
        function openScanner() {
            Quagga.init({
                inputStream: {
                    name: "Live",
                    type: "LiveStream",
                    target: document.querySelector('#scanner-container'),
                    constraints: {
                        width: 400,
                        height: 300,
                        facingMode: "environment" // atau "user" untuk kamera depan
                    }
                },
                decoder: {
                    readers: ["code_128_reader"] // atau jenis barcode lain yang ingin Anda scan
                }
            }, function(err) {
                if (err) {
                    console.error(err);
                    return;
                }
                Quagga.start();
            });

            Quagga.onDetected(function(data) {
                Quagga.stop();
                let code = data.codeResult.code;
                console.log('Detected Barcode:', code); // Logging untuk debug
                document.getElementById('scanned-result').innerText = 'Scanned Barcode: ' + code;
                window.location.href = `/guest/checkout/${code}`;
            });

        }

        openScanner();
    </script>
@endsection
