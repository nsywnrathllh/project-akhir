@extends('layouts.template-mazer')
@section('content')
    @notifyCss
    <div class="page-heading">
        <h3>Add Notification Target</h3>
    </div>
    <div class="card">
        <div class="card-body col-12 col-md-8">
            <form action="{{ route('notification-target.store') }}" method="POST">
                @csrf
                @method('post')

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
                        <option value="Hubin" {{ old('destination') == 'Hubin' ? 'selected' : '' }}>Hubin
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

                <button type="submit" class="btn btn-primary">Save</button>
            </form>
        </div>
    </div>

    <x-notify::notify />
    @notifyJs
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.1.3/dist/js/bootstrap.bundle.min.js"
        integrity="sha384-ka7Sk0Gln4gmtz2MlQnikT1wXgYsOg+OMhuP+IlRH9sENBO0LRn5q+8nbTov4+1p" crossorigin="anonymous">
    </script>
@endsection
