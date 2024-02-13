@extends('layouts.template-mazer')
@section('content')
    <link rel="stylesheet" href="{{ asset('mazer/assets/extensions/simple-datatables/style.css') }}">
    <link rel="stylesheet" href="{{ asset('mazer/assets/compiled/css/table-datatable.css') }}">
    <div class="page-heading">
        <h3>Data Logs</h3>
    </div>
    <div class="page-content">

        @if ($message = session('success'))
            <div class="alert alert-light-success color-success"><i class="bi bi-check-circle"></i>
                {{ $message }}
            </div>
        @endif
        <div class="card">
            <div class="card-body">
                <table class="table responsive" id="table1">
                    <thead>
                        <tr>
                            <th scope="col">No</th>
                            <th scope="col">Vehicle</th>
                            <th scope="col">Name</th>
                            <th scope="col">Phone</th>
                            <th scope="col">Destination</th>
                            <th scope="col">Purpose</th>
                            <th scope="col">CheckIn</th>
                            <th scope="col">CheckOut</th>
                            <th scope="col">Image</th>
                            <th scope="col">Status</th>
                        </tr>
                    </thead>
                    <tbody>
                        @foreach ($guests as $key => $guest)
                            <tr>
                                <td>{{ $key + 1 }}</td>
                                <td>{{ $guest->name }}</td>
                                <td>{{ $guest->vehicles->type }}</td>
                                <td>{{ $guest->phone }}</td>
                                <td>{{ $guest->destination }}</td>
                                <td>{{ $guest->purpose }}</td>
                                <td>{{ $guest->checkin }}</td>
                                <td>{{ $guest->checkout }}</td>
                                <td>{{ $guest->image }}</td>
                                <td>{{ $guest->status }}</td>
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
