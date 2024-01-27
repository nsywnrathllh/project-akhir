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
                <a href="{{route('guest.create')}}" class="btn btn-success mb-3"><i class="bi bi-plus"></i>&nbsp; Add</a>

                <table class="table responsive" id="table1">
                    <thead>
                        <tr>
                            <th>No</th>
                            <th>Name</th>
                            <th>Phone</th>
                            <th>Destination</th>
                            <th>Purpose</th>
                            <th>CheckIn</th>
                            <th>CheckOut</th>
                            <th>Image</th>
                            <th>Status</th>
                            <th>Action</th>
                        </tr>
                    </thead>
                    <tbody>
                        @foreach ($guests as $item)
                            <tr>
                                <td>{{ $loop->iteration }}</td>
                                <td>{{ $item->name }}</td>
                                <td>{{ $item->phone }}</td>
                                <td>{{ $item->destination }}</td>
                                <td>{{ $item->purpose }}</td>
                                <td>{{ $item->checkin }}</td>
                                <td>{{ $item->checkout }}</td>
                                <td>{{ $item->image }}</td>
                                <td>{{ $item->status }}</td>
                                <td class="d-flex">
                                    <a href="{{ route('guest.edit', $item->id) }}" class="btn btn-warning btn-sm mr-1"><i class="bi bi-pencil-square"></i>&nbsp;
                                        Edit
                                    </a>
                                    <form action="{{ route('guest.destroy', $item->id) }}" method="POST">
                                        @csrf
                                        @method('delete')
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

    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.1.3/dist/js/bootstrap.bundle.min.js"
        integrity="sha384-ka7Sk0Gln4gmtz2MlQnikT1wXgYsOg+OMhuP+IlRH9sENBO0LRn5q+8nbTov4+1p" crossorigin="anonymous">
    </script>
@endsection