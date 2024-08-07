@extends('layouts.template-mazer')
@section('content')
<div class="page-heading">
        <h3>Data Target Notifikasi</h3>
    </div>
    <div class="page-content">
        <div class="card">
            <div class="card-body">
                <div class="mb-3">
                    <a href="{{ route('notification-targets.create') }}" class="btn btn-primary">
                        <i class="bi bi-plus"></i>
                    </a>
                </div>
                <table class="table responsive" id="table1">
                    <thead>
                        <tr>
                            <th scope="col">No</th>
                            <th scope="col">Nomor Telepon</th>
                            <th scope="col">Destinasi</th>
                            <th scope="col">Opsi</th>
                        </tr>
                    </thead>
                    <tbody>
                        @foreach ($targets as $key => $item)
                            <tr>
                                <td>{{ $key + 1 }}</td>
                                <td>{{ $item->phone }}</td>
                                <td>{{ $item->destination }}</td>
                                <td>
                                    <form class="d-inline-block"
                                        onsubmit="return confirm('Are you sure you want to delete this item?')"
                                        action="{{ route('notification-targets.destroy', $item->id) }}" method="POST">
                                        @csrf
                                        @method('DELETE')
                                        <button type="submit" class="btn btn-danger" style="background-color: rgb(221, 66, 66);"><i class="bi bi-trash"></i></button>
                                    </form>
                                </td>
                            </tr>
                        @endforeach
                    </tbody>
                </table>
            </div>
        </div>
    </div>
    @push('css')
    @notifyCss
        <link rel="stylesheet" href="{{ asset('mazer/assets/extensions/simple-datatables/style.css') }}">
        <link rel="stylesheet" href="{{ asset('mazer/assets/compiled/css/table-datatable.css') }}">
        <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.11.3/font/bootstrap-icons.min.css">
    @endpush
    @push('js')
    @notifyJs
        <script src="{{ asset('mazer/assets/extensions/simple-datatables/umd/simple-datatables.js') }}"></script>
        <script src="{{ asset('mazer/assets/static/js/pages/simple-datatables.js') }}"></script>
    @endpush
    <x-notify::notify />
@endsection
