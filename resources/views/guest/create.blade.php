<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.1.3/dist/css/bootstrap.min.css" rel="stylesheet"
        integrity="sha384-1BmE4kWBq78iYhFldvKuhfTAU6auU8tT94WrHftjDbrCEXSU1oBoqyl2QvZ6jIW3" crossorigin="anonymous">
</head>

<body>
    <div class="container mt-5">
        <div class="card">
            <h1 class="text-center fs-2 mt-4">CREATE GUEST</h1>
            <div class="card-body">

                <form action="{{ route('guest.store') }}" method="POST" enctype="multipart/form-data">
                    @csrf
                    <div class="mb-3">
                        <label class="form-label">Name</label>
                        <input value="{{ old('name') }}" name="name" type="text"
                            class="form-control @error('name') is-invalid @enderror">
                        @error('name')
                            <div class="invalid-feedback">{{ $message }}</div>
                        @enderror
                    </div>

                    <div class="mb-3">
                        <label class="form-label">Phone</label>
                        <input value="{{ old('phone') }}" name="phone" type="number"
                            class="form-control @error('phone') is-invalid @enderror">
                        @error('phone')
                            <div class="invalid-feedback">{{ $message }}</div>
                        @enderror
                    </div>

                    <div class="mb-3">
                        <label class="form-label">Destination</label>
                        <select name="destination" class="form-control @error('destination') is-invalid @enderror">
                            <option value="TU" {{ old('destination') == 'TU' ? 'selected' : '' }}>TU</option>
                            <!-- Add other options here -->
                        </select>
                        @error('destination')
                            <div class="invalid-feedback">{{ $message }}</div>
                        @enderror
                    </div>

                    <div class="mb-3">
                        <label for="purpose" class="form-label">Purpose</label>
                        <input type="text" class="form-control" name="purpose" value="{{ old('purpose') }}">
                        @error('purpose')
                            <div class="alert alert-danger">{{ $message }}</div>
                        @enderror
                    </div>

                    <div class="mb-3">
                        <label for="checkin" class="form-label">Checkin</label>
                        <input type="date" class="form-control" name="checkin" value="{{ old('checkin') }}">
                        @error('checkin')
                            <div class="alert alert-danger">{{ $message }}</div>
                        @enderror
                    </div>

                    <div class="mb-3">
                        <label for="checkout" class="form-label">Checkout</label>
                        <input type="date" class="form-control" name="checkout" value="{{ old('checkout') }}">
                        @error('checkout')
                            <div class="alert alert-danger">{{ $message }}</div>
                        @enderror
                    </div>

                    <div class="mb-3">
                        <label for="image" class="form-label">Image</label>
                        <input type="text" class="form-control" name="image" value="{{ old('image') }}">
                        @error('image')
                            <div class="alert alert-danger">{{ $message }}</div>
                        @enderror
                    </div>

                    <div class="mb-3">
                        <label class="form-label">Status</label>
                        <select name="status" class="form-control @error('status') is-invalid @enderror">
                            <option value="Check Out" {{ old('status') == 'Check Out' ? 'selected' : '' }}>Check Out
                            </option>
                            <option value="Still Inside" {{ old('status') == 'Still Inside' ? 'selected' : '' }}>Still
                                Inside
                            </option>
                        </select>
                        @error('status')
                            <div class="invalid-feedback">{{ $message }}</div>
                        @enderror
                    </div>
                    <button type="submit" class="btn btn-dark">Submit</button>
                </form>
            </div>
        </div>
    </div>
</body>

</html>
