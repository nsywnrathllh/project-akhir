@extends('layouts.template-mazer')
@section('content')
    @notifyCss
    <div class="page-heading">
        <h3>Masukkan Data Tamu</h3>
    </div>
    <div class="card">
        <div class="card-body col-12 col-md-8">
            <form action="{{ route('guests.store') }}" method="POST" enctype="multipart/form-data">
                @csrf
                <input type="hidden" name="image_data" id="imageData" value="">
                @method('post')

                <x-text-input name="name" label="Nama" required />
                <x-text-input name="phone" label="Nomor Telepon" required />
                <x-text-input name="alliance" label="Asal" required />

                <div class="mb-3">
                    <label class="form-label">Tujuan Destinasi</label>
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
                        <option value="Hubin" {{ old('destination') == 'Hubin' ? 'selected' : '' }}>Hubin
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

                <x-text-input name="purpose" label="Tujuan Berkunjung" required />
                <div class="form-group">
                    <label for="has_vehicle">Opsi Kendaraan</label>
                    <select class="form-control" id="has_vehicle" name="has_vehicle" required>
                        <option value="Yes">Membawa Kendaraan</option>
                        <option value="No" selected>Tidak Membawa Kendaraan</option>
                    </select>
                    @error('has_vehicle')
                        <div class="alert alert-danger">{{ $message }}</div>
                    @enderror
                </div>

                <div class="form-group" id="vehicle_fields" style="display: none;">
                    <label for="type">Jenis Kendaraan</label>
                    <input type="text" class="form-control" id="type" name="type">
                </div>

                <div class="form-group" id="license_plate_fields" style="display: none;">
                    <label for="license_plate">Plat Nomor</label>
                    <input type="text" class="form-control" id="license_plate" name="license_plate">
                </div>

                <x-text-input type="datetime-local" name="checkin" label="Jam Masuk" required />
                <x-text-input readonly type="datetime-local" name="checkout" label="Jam Keluar (Tidak Wajib Diisi)" />

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
                
                <div class="mb-3">
                    <div class="card-body">
                        <h3 class="card-title">Ambil Gambar Wajah</h3>
                        <div>
                            <video id="cameraFeed" width="100%" height="auto" autoplay></video>
                            <canvas id="canvas" style="display: none;"></canvas>
                            <img id="capturedImage" src="#" alt="">
                        </div>
                    </div>
                </div>

                <input type="hidden" name="image_path" id="imageData" value="">
                <button onclick="capturePhotoAndSave(); showCapturedImage();" id="btnSimpan" class="btn btn-primary mt-3">
                    Ambil Gambar dan Simpan</button>
            </form>
        </div>
    </div>

    <x-notify::notify />
    @notifyJs
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
            const imageDataInput = document.getElementById('imageData');

            canvas.width = 400;
            canvas.height = 300;
            canvas.getContext('2d').drawImage(video, 0, 0, canvas.width, canvas.height);

            const imageData = canvas.toDataURL('image/png');
            imageDataInput.value = imageData; // Simpan gambar ke input tersembunyi
        }

        setupCamera();
    </script>

    <script>
        document.addEventListener('DOMContentLoaded', function() {
            var hasVehicleSelect = document.getElementById('has_vehicle');
            var vehicleFields = document.getElementById('vehicle_fields');
            var licensePlateFields = document.getElementById('license_plate_fields');

            // Tampilkan atau sembunyikan input tergantung pada opsi kendaraan yang dipilih
            hasVehicleSelect.addEventListener('change', function() {
                if (hasVehicleSelect.value === 'Yes') {
                    vehicleFields.style.display = 'block';
                    licensePlateFields.style.display = 'block';
                } else {
                    vehicleFields.style.display = 'none';
                    licensePlateFields.style.display = 'none';
                }
            });

            // Inisialisasi tampilan input sesuai dengan nilai opsi kendaraan saat ini
            if (hasVehicleSelect.value === 'Yes') {
                vehicleFields.style.display = 'block';
                licensePlateFields.style.display = 'block';
            }
        });
    </script>

    <script>
        document.addEventListener('DOMContentLoaded', function() {
            // Tangkap peristiwa klik tombol "Simpan"
            document.getElementById('btnSimpan').addEventListener('click', function() {
                // Lakukan redirect ke halaman cetak setelah klik tombol "Simpan"
                window.location.href = "{{ route('guests.print', ['guestId']) }}";
            });
        });
    </script>
@endsection
