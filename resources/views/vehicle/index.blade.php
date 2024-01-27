@extends('layouts.template-mazer')
@section('content')

<link rel="stylesheet" href="{{ asset('mazer/assets/extensions/simple-datatables/style.css') }}">
<link rel="stylesheet" href="{{ asset('mazer/assets/compiled/css/table-datatable.css') }}">
<div class="page-heading">
    <h3>Data Vehicle</h3>
</div>
    <div class="page-content">

        @if ($message = session('success'))
                    <div class="alert alert-light-success color-success"><i class="bi bi-check-circle"></i>
                        {{ $message }}
                    </div>
        @endif
        <div class="card">
            <div class="card-body">
                <a href="{{route('vehicles.create')}}" class="btn btn-success mb-3"><i class="bi bi-plus"></i>&nbsp; Add</a>

                <table class="table responsive" id="table1">
                    <thead>
                            <th scope="col">No</th>
                            <th scope="col">Type</th>
                            <th scope="col">License Plate</th>
                            <th scope="col">Action</th>
                    </thead>
                    <tbody>
                        @foreach ($vehicle as $key => $item)
                            <tr>
                                <td>{{ $key+1}}</td>
                                <td>{{ $item->type }}</td>
                                <td>{{ $item->license_plate }}</td>
                                <td class="d-flex">
                                    <a href="{{ route('vehicles.edit', $item->id) }}" class="btn btn-warning btn-sm mr-1"><i class="bi bi-pencil-square"></i>&nbsp;
                                        Edit
                                    </a>
                                        <form method="POST" action="{{ route('vehicles.destroy', $item->id) }}" class="ms-2">
                                            @csrf
                                            @method('DELETE')
                                            <button type="submit" class="btn btn-sm btn-danger sm-1" onclick="return confirm('Are you sure you want to delete this data?')"><i class="bi bi-trash"></i>&nbsp;
                                                Delete
                                            </button>
                                        </form>
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