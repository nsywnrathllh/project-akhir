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
                            <th scope="col">Name</th>
                            <th scope="col">Address</th> <!-- Tambah field Address -->
                            <th scope="col">Logo</th> <!-- Tambah field Logo -->
                            <th scope="col">Option</th>
                        </tr>
                    </thead>
                    <tbody>
                        @foreach ($settings as $key => $item)
                            <tr>
                                <td>{{ $key + 1 }}</td>
                                <td>{{ $item->name }}</td>
                                <td>{{ $item->address }}</td> <!-- Tambah field Address -->
                                <td>
                                    @if ($item->logo_path)
                                        <img src="{{ asset($item->logo_path) }}"
                                            style="max-width: 100px; max-height: 100px;" alt="Guest Logo">
                                    @else
                                        No Logo
                                    @endif
                                </td> <!-- Tambah field Logo -->
                                <td>
                                    <a href="{{ route('settings.edit', $item->id) }}" class="btn btn-primary">Edit</a>
                                    <!-- Ganti route dengan yang sesuai dan sesuaikan tampilan tombol sesuai kebutuhan -->
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
