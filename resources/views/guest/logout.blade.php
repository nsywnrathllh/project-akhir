@extends('layouts.template-mazer')

@section('content')
    <div class="page-heading">
        <h3>Logout</h3>
    </div>
    <div class="card">
        <div class="card-body">
            <div class="container col-lg-10 py-11">
                <div class="card shadow rounded-3 p-3 border-0">
                    {{-- <p class="text-center mb-3" style="color: #98f0ff;">Thank you for visiting!</p> --}}
                    <p class="text-center mb-3" style="color: #98f0ff;">Scan to logout</p>
                    <video id="preview" playsinline autoplay muted style="width: 100%;"></video>
                    <form action="{{ route('guest.scan') }}" method="POST" id="form">
                        @csrf
                        <input type="hidden" name="guest_id" id="guest_id">
                        <input type="hidden" name="status" id="status" value="Still Inside">
                    </form>
                </div>
            </div>
            <p id="scanned-result"></p>
        </div>
    </div>

    <script src="https://rawgit.com/schmich/instascan-builds/master/instascan.min.js"></script>
    <script>
        document.addEventListener('DOMContentLoaded', function() {
            let scanner = new Instascan.Scanner({
                video: document.getElementById('preview')
            });

            Instascan.Camera.getCameras().then(function(cameras) {
                if (cameras.length > 0) {
                    scanner.start(cameras[0]);
                } else {
                    console.error('No cameras found.');
                }
            }).catch(function(e) {
                console.error(e);
            });

            scanner.addListener('scan', function(c) {
                document.getElementById('guest_id').value = c;
                document.getElementById('form').submit();
            });
        });
    </script>

    <script src="https://cdnjs.cloudflare.com/ajax/libs/quagga/0.12.1/quagga.min.js"></script>
    <script>
        function openScanner() {
            Quagga.init({
                inputStream: {
                    name: "Live",
                    type: "LiveStream",
                    target: document.querySelector('#scanner-container video'),
                    constraints: {
                        width: 400,
                        height: 300,
                        facingMode: "environment"
                    }
                },
                decoder: {
                    readers: ["code_128_reader"]
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
                console.log('Detected Barcode:', code);
                document.getElementById('scanned-result').innerText = 'Scanned Barcode: ' + code;
                window.location.href = `/guest/checkout/${code}`;
            });

        }

        openScanner();
    </script>
    <script>
        @if (Session::has('success'))
            toastr.info("{{ Session::get('success') }}", "Okei!", {
                positionClass: "toast-top-center"
            });
        @elseif (Session::has('failed'))
            toastr.error("{{ Session::get('failed') }}", "Oops!", {
                positionClass: "toast-top-center"
            });
        @endif
    </script>
@endsection
