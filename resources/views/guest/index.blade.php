@extends('layouts.template-mazer')
@section('content')
    <link rel="stylesheet" href="{{ asset('mazer/assets/extensions/simple-datatables/style.css') }}">
    <link rel="stylesheet" href="{{ asset('mazer/assets/compiled/css/table-datatable.css') }}">
    <div class="page-heading">
        <h3>Data Guest</h3>
    </div>
    <div class="page-content">
        <div class="card">
            <div class="card-body">
                <table class="table responsive" id="table1">
                    <thead>
                        <tr>
                            <th scope="col">No</th>
                            <th scope="col">QR</th>
                            <th scope="col">Name</th>
                            <th scope="col">Phone</th>
                            <th scope="col">Alliance</th>
                            <th scope="col">Destination</th>
                            <th scope="col">Purpose</th>
                            <th scope="col">KTP</th>
                            <th scope="col">Vehicle</th>
                            <th scope="col">Tipe Kendaraan</th>
                            <th scope="col">Plat Nomor</th>
                            <th scope="col">CheckIn</th>
                            <th scope="col">CheckOut</th>
                            <th scope="col">Image</th>
                            <th scope="col">Status</th>
                            <th scope="col">Scan</th>
                        </tr>
                    </thead>
                    <tbody>
                        @foreach ($guest as $key => $item)
                            <tr>
                                <td>{{ $key + 1 }}</td>
                                <td><img src="{{ (new \chillerlan\QRCode\QRCode())->render(json_encode($item->id ?? null)) }}"
                                        alt="QR" style="width: 100px; height: 100px;">
                                </td>
                                <td>{{ $item->name }}</td>
                                <td>{{ $item->phone }}</td>
                                <td>{{ $item->alliance }}</td>
                                <td>{{ $item->destination }}</td>
                                <td>{{ $item->purpose }}</td>
                                <td>{{ $item->scan_ktp }}</td>
                                {{-- <td>
                                    @if ($item->scan_ktp)
                                        <img src="{{ Storage::url($item->scan_ktp) }}"
                                            style="max-width: 100px; max-height: 100px;" alt="Scan KTP Image">
                                    @else
                                        No Image
                                    @endif
                                </td> --}}
                                <td>{{ $item->has_vehicle }}</td>
                                <td>
                                    @foreach ($item->vehicles as $vehicle)
                                        {{ $vehicle->type }}
                                    @endforeach
                                </td>
                                <td>
                                    @foreach ($item->vehicles as $vehicle)
                                        {{ $vehicle->license_plate }}
                                    @endforeach
                                </td>
                                <td>{{ $item->checkin }}</td>
                                <td>{{ $item->checkout }}</td>
                                <td>
                                    @if ($item->image_path)
                                        <img src="{{ asset($item->image_path) }}"
                                            style="max-width: 100px; max-height: 100px;" alt="Guest Image">
                                    @else
                                        No Image
                                    @endif
                                </td>
                                <td>{{ $item->status }}</td>
                                <td>{{ $item->scan }}</td>
                                <td>
                                <td>
                                    @if ($item->status == 'Still Inside')
                                        <a href="{{ route('guest.scan', $item->id) }}" class="btn btn-info">Scan
                                            Checkout</a>
                                    @else
                                        Already Checked Out
                                    @endif
                                </td>
                                </td>
                            </tr>
                        @endforeach
                    </tbody>
                </table>
            </div>
        </div>
    </div>

    <script src="{{ asset('mazer/assets/extensions/simple-datatables/umd/simple-datatables.js') }}"></script>
    <script src="{{ asset('mazer/assets/static/js/pages/simple-datatables.js') }}"></script>
@endsection
