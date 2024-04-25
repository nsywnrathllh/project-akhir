<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    {{-- <title>{{ $setting->name }} | Print page</title> --}}
    <link rel="stylesheet" href="{{ asset('css/print.css') }}">

    {{-- Bootstrap Icon --}}
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.11.2/font/bootstrap-icons.min.css">

    {{-- Bootstrap --}}
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/css/bootstrap.min.css" rel="stylesheet"
        integrity="sha384-T3c6CoIi6uLrA9TneNEoa7RxnatzjcDSCmG1MXxSR1GAsXEV/Dwwykc2MPK8M2HN" crossorigin="anonymous">
</head>

<body>
    <form action="">
        <div class="body-container">
            <div class="logo-container" style="display: flex; justify-content: center; align-items: center;">
                <img style="max-width:100px; max-height:50px; margin-right: 35px;" src="{{ asset('logo/logo.png') }}">
            </div>
            <div class="text-center">
                <input type="text" class="text-capitalize fst-italic bg-transparent border-0" id="address"
                    value="{{ $setting->address }}" readonly>
            </div>
            <div class="mt-3">
                <div class="text-start ps-1">
                    <div class="">
                        <p class="mb-0"><span class="fw-bold">Nama :</span><br>{{ $userName }}</p>
                    </div>
                    <div class="mt-2">
                        <p class="mb-0"><span class="fw-bold">Nomor Handphone :</span><br>{{ $maskedPhoneNumber }}</p>
                    </div>
                    <div class="mt-2">
                        <p class="mb-0"><span class="fw-bold">Asal Aliansi :</span><br>{{ $alliance }}</p>
                    </div>
                    <div class="mt-2">
                        <p class="mb-0"><span class="fw-bold">Tujuan :</span><br>{{ $purpose }}</p>
                    </div>
                    <div class="mt-2">
                        <p class="mb-0"><span class="fw-bold">Waktu Masuk :</span><br>{{ $checkIn }}</p>
                    </div>
                    <div class="text-center mt-4">
                        <img src="{{ (new \chillerlan\QRCode\QRCode())->render(json_encode($guestData->id ?? null)) }}"
                            alt="QR" style="width: 150px; height: 150px;">
                    </div>
                </div>
            </div>
            <p class="mt-3">-</p>
        </div>
    </form>

    <script type="text/javascript">
        window.print();
    </script>

    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/js/bootstrap.bundle.min.js"
        integrity="sha384-C6RzsynM9kWDrMNeT87bh95OGNyZPhcTNXj1NW7RuBCsyN/o0jlpcV8Qyq46cDfL" crossorigin="anonymous">
    </script>
</body>

</html>
