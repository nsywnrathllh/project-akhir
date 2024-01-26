<!DOCTYPE html>
<html lang="en">

<head>
    <!-- Required meta tags -->
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">

    <!-- Bootstrap CSS -->
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.1.3/dist/css/bootstrap.min.css" rel="stylesheet"
        integrity="sha384-1BmE4kWBq78iYhFldvKuhfTAU6auU8tT94WrHftjDbrCEXSU1oBoqyl2QvZ6jIW3" crossorigin="anonymous">

    {{-- <title>{{$title->name}} | Results</title> --}}
</head>

<body>
    <div class="container">
        <div class="card">
            <div class="card-body" style="background-color: #F5F7F8;">
                <h1 class="text-center fs-2 mt-4">DATA GUESTS</h1>

                <div class="mb-3">
                    <a href="{{ route('guest.create') }}" class="btn btn-primary">Tambah</a>
                </div>

                <table class="table">
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
                                <td>
                                    <form action="{{ route('guest.destroy', $item->id) }}" method="POST">
                                        @csrf
                                        @method('delete')
                                        <button type="submit" class="btn btn-dark m-1"
                                            onclick="return confirm('Are you sure you want to delete this data?')">Delete</button>
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
</body>

</html>
