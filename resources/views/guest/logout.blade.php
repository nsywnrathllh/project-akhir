@extends('layouts.template-mazer')

@section('content')
    <div class="page-heading">
        <h3>Logout</h3>
    </div>
    <div class="card">
        <div class="card-body">
            <div class="container col-lg-10 py-11">
                <div class="card shadow rounded-3 p-3 border-0">
                    <p class="text-center mb-3" style="color: #000000;">Thank you for visiting!</p>
                    <p class="text-center mb-3" style="color: #000000;">Scan to logout</p>
                    <video id="preview" playsinline autoplay muted style="width: 100%;"></video>
                    <form action="{{ route('guest.scan.post') }}" method="POST" id="form">
                        @csrf
                        <input type="hidden" name="guest_id" id="guest_id">
                    </form>
                </div>
            </div>
            <h4 class="text-center">Hasilnya Dibawah ini:</h4>
            <h1 class="text-center" style="text-red" id="scanned-result"></h1>
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
                document.getElementById('scanned-result').innerText = c;

                // *** uncomment kode dibawah ini jika ingin langsung submit setelah scan
                document.getElementById('form').submit();
            });
        });
    </script>
@endsection
