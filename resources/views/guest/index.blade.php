@extends('layouts.template-mazer')
@section('content')
    <link rel="stylesheet" href="{{ asset('mazer/assets/extensions/simple-datatables/style.css') }}">
    <link rel="stylesheet" href="{{ asset('mazer/assets/compiled/css/table-datatable.css') }}">
    <div class="page-heading">
        <h3>Data Guest</h3>
    </div>
    <div class="page-content">

        @if ($message = session('success'))
            <div class="alert alert-light-success color-success"><i class="bi bi-check-circle"></i>
                {{ $message }}
            </div>
        @endif
        <div class="card">
            <div class="card-body">
                <a href="{{ route('guests.create') }}" class="btn btn-success mb-3"><i class="bi bi-plus"></i>&nbsp; Add</a>

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
                            <th scope="col">Action</th>
                        </tr>
                    </thead>
                    <tbody>
                        @foreach ($guest as $key => $item)
                            <tr>
                                <td>{{ $key + 1 }}</td>
                                <td>{{ $item->name }}</td>
                                <td>{{ $item->vehicles->type }}</td>
                                <td>{{ $item->phone }}</td>
                                <td>{{ $item->destination }}</td>
                                <td>{{ $item->purpose }}</td>
                                <td>{{ $item->checkin }}</td>
                                <td>{{ $item->checkout }}</td>
                                <td>{{ $item->image }}</td>
                                <td>{{ $item->status }}</td>
                                <td class="d-flex">
                                    <a href="{{ route('guests.edit', $item->id) }}" class="btn btn-warning btn-sm mr-1"><i
                                            class="bi bi-pencil-square"></i>&nbsp;
                                        Edit
                                    </a>
                                    <form method="POST" action="{{ route('guests.destroy', $item->id) }}" class="ms-2">
                                        @csrf
                                        @method('DELETE')
                                        <button type="submit" class="btn btn-sm btn-danger sm-1"
                                            onclick="return confirm('Are you sure you want to delete this data?')"><i
                                                class="bi bi-trash"></i>&nbsp;
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

    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.1.3/dist/js/bootstrap.bundle.min.js"
        integrity="sha384-ka7Sk0Gln4gmtz2MlQnikT1wXgYsOg+OMhuP+IlRH9sENBO0LRn5q+8nbTov4+1p" crossorigin="anonymous">
    </script>
@endsection
