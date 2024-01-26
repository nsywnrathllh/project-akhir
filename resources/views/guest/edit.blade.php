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
            <h1 class="text-center fs-2 mt-4">EDIT GUESTS</h1>
            <div class="card-body">

                <form action="{{ route('guest.update', $guests->id) }}" method="POST" enctype="multipart/form-data">
                    @csrf
                    @method('put')
                    <div class="mb-3">
                        <label class="form-label">Name</label>
                        <input value="{{ $guests->name }}" name="name" type="text"
                            class="form-control @error('name') is-invalid @enderror">
                        @error('name')
                            <div class="invalid-feedback">{{ $message }}</div>
                        @enderror
                    </div>

                    <div class="mb-3">
                        <label class="form-label">Phone</label>
                        <input value="{{ $guests->phone }}" name="phone" type="text"
                            class="form-control @error('phone') is-invalid @enderror">
                        @error('phone')
                            <div class="invalid-feedback">{{ $message }}</div>
                        @enderror
                    </div>

                    <div class="mb-3">
                        <label class="form-label">Destination</label>
                        <select name="destination" class="form-control @error('destination') is-invalid @enderror">
                            <option value="TU" {{ $guests->destination == 'TU' ? 'selected' : '' }}>TU</option>
                            <option value="Walikelas" {{ $guests->destination == 'Walikelas' ? 'selected' : '' }}>
                                Walikelas</option>
                            <!-- ... (sisa opsi) ... -->
                        </select>
                        @error('destination')
                            <div class="invalid-feedback">{{ $message }}</div>
                        @enderror
                    </div>

                    <div class="mb-3">
                        <label class="form-label">Purpose</label>
                        <input value="{{ $guests->purpose }}" name="purpose" type="text"
                            class="form-control @error('purpose') is-invalid @enderror">
                        @error('purpose')
                            <div class="invalid-feedback">{{ $message }}</div>
                        @enderror
                    </div>

                    <div class="mb-3">
                        <label class="form-label">Checkin</label>
                        <input value="{{ $guests->checkin }}" name="checkin" type="text"
                            class="form-control @error('checkin') is-invalid @enderror">
                        @error('checkin')
                            <div class="invalid-feedback">{{ $message }}</div>
                        @enderror
                    </div>

                    <div class="mb-3">
                        <label class="form-label">Checkout</label>
                        <input value="{{ $guests->checkout }}" name="checkout" type="text"
                            class="form-control @error('checkout') is-invalid @enderror">
                        @error('checkout')
                            <div class="invalid-feedback">{{ $message }}</div>
                        @enderror
                    </div>

                    <div class="mb-3">
                        <label class="form-label">Image</label>
                        <input value="{{ $guests->image }}" name="image" type="text"
                            class="form-control @error('image') is-invalid @enderror">
                        @error('image')
                            <div class="invalid-feedback">{{ $message }}</div>
                        @enderror
                    </div>

                    <div class="mb-3">
                        <label class="form-label">Status</label>
                        <select name="status" class="form-control @error('status') is-invalid @enderror">
                            <option value="Check Out" {{ $guests->status == 'Check Out' ? 'selected' : '' }}>Check Out
                            </option>
                            <option value="Still Inside" {{ $guests->status == 'Still Inside' ? 'selected' : '' }}>
                                Still
                                Inside
                            </option>
                        </select>
                        @error('status')
                            <div class="invalid-feedback">{{ $message }}</div>
                        @enderror
                    </div>

                    <button type="submit" class="btn btn-dark">Update</button>
                </form>
            </div>
        </div>
    </div>

    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.1.3/dist/js/bootstrap.bundle.min.js"
        integrity="sha384-ka7Sk0Gln4gmtz2MlQnikT1wXgYsOg+OMhuP+IlRH9sENBO0LRn5q+8nbTov4+1p" crossorigin="anonymous">
    </script>
</body>

</html>
