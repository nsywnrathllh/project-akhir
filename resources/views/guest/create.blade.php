@extends('layouts.template-mazer')
@section('content')
    <div class="page-heading">
        <h3>Add Data Guest</h3>
    </div>
    <div class="card">
        <div class="card-body col-12 col-md-8">
            <form action="{{ route('guests.store') }}" method="POST">
                @csrf
                <input type="hidden" name="image_data" id="imageData" value="">
                @method('post')
                <div class="mb-3">
                    <div class="card-body">
                        <h3 class="card-title">Ambil Foto</h3>
                        <div>
                            <video id="cameraFeed" width="100%" height="auto" autoplay></video>
                            <canvas id="canvas" style="display: none;"></canvas>
                            <img id="capturedImage" src="#" alt="Captured Image">
                        </div>
                    </div>
                </div>

                <label class="form-label">Vehicle</label>
                <select name="vehicles_id" class="form-control @error('vehicles_id') is-invalid @enderror">
                    @foreach ($vehicles as $vehicle)
                        <option value="{{ $vehicle->id }}" {{ old('vehicles_id') == $vehicle->id ? 'selected' : '' }}>
                            {{ $vehicle->type }}
                        </option>
                    @endforeach
                </select>
                @error('vehicles_id')
                    <div class="invalid-feedback">{{ $message }}</div>
                @enderror

                <x-text-input name="name" label="Name" required />
                <x-text-input name="phone" label="Phone Number" required />

                <div class="mb-3">
                    <label class="form-label">Destination</label>
                    <select name="destination" class="form-control @error('destination') is-invalid @enderror">
                        <option value="TU" {{ old('destination') == 'TU' ? 'selected' : '' }}>TU</option>
                        <option value="Walikelas" {{ old('destination') == 'Walikelas' ? 'selected' : '' }}>Wali Kelas
                        </option>
                        <option value="Guru" {{ old('destination') == 'Guru' ? 'selected' : '' }}>Guru</option>
                        <option value="Bendahara" {{ old('destination') == 'Bendahara' ? 'selected' : '' }}>Bendahara
                        </option>
                        <option value="Kurikulum" {{ old('destination') == 'Kurikulum' ? 'selected' : '' }}>Kurikulum
                        </option>
                        <option value="Kesiswaan" {{ old('destination') == 'Kesiswaan' ? 'selected' : '' }}>Kesiswaan
                        </option>
                        <option value="Kepala Sekolah" {{ old('destination') == 'Kepala Sekolah' ? 'selected' : '' }}>
                            Kepala Sekolah
                        </option>
                        <option value="Meeting" {{ old('destination') == 'Meeting' ? 'selected' : '' }}>Meeting</option>
                        <option value="Lainnya" {{ old('destination') == 'Lainnya' ? 'selected' : '' }}>Lainnya
                        </option>
                    </select>
                    @error('destination')
                        <div class="invalid-feedback">{{ $message }}</div>
                    @enderror
                </div>

                <x-text-input name="purpose" label="Purpose" required />
                <x-text-input type="time" name="checkin" label="Check In" required />
                <x-text-input type="time" name="checkout" label="Check Out" />

                <div class="mb-3">
                    <label class="form-label">Status</label>
                    <select name="status" class="form-control @error('status') is-invalid @enderror">
                        <option value="Check Out" {{ old('status') == 'Check Out' ? 'selected' : '' }}>Check Out</option>
                        <option value="Still Inside" selected {{ old('status') == 'Still Inside' ? 'selected' : '' }}>
                            Still Inside
                        </option>
                    </select>
                    @error('status')
                        <div class="invalid-feedback">{{ $message }}</div>
                    @enderror
                </div>

                <input type="hidden" name="image_data" id="imageData" value="">
                <button onclick="capturePhotoAndSave(); showCapturedImage();" class="btn btn-primary mt-3"> Ambil Foto dan
                    Simpan</button>
            </form>
        </div>
    </div>

    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.1.3/dist/js/bootstrap.bundle.min.js"
        integrity="sha384-ka7Sk0Gln4gmtz2MlQnikT1wXgYsOg+OMhuP+IlRH9sENBO0LRn5q+8nbTov4+1p" crossorigin="anonymous">
    </script>

    <script>
        async function setupCamera() {
            const constraints = {
                video: {
                    width: 400,
                    height: 300
                }
            };

            const video = document.getElementById('cameraFeed');
            try {
                const stream = await navigator.mediaDevices.getUserMedia(constraints);
                video.srcObject = stream;
            } catch (err) {
                console.error('Error accessing the camera:', err);
            }
        }

        function capturePhotoAndSave() {
            const video = document.getElementById('cameraFeed');
            const canvas = document.getElementById('canvas');
            const photo = document.getElementById('capturedImage');
            const imageDataInput = document.getElementById('imageData');

            canvas.width = 400;
            canvas.height = 300;
            canvas.getContext('2d').drawImage(video, 0, 0, canvas.width, canvas.height);

            const imageData = canvas.toDataURL('image/png');
            photo.setAttribute('src', imageData);
            imageDataInput.value = imageData;
        }

        function showCapturedImage() {
            const photo = document.getElementById('capturedImage');
            photo.style.display = 'block';
        }

        setupCamera();
    </script>
@endsection
