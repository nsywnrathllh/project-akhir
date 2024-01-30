@extends('layouts.template-mazer')
@section('content')
    <div class="page-heading">
        <h3>Add Data Guest</h3>
    </div>
    <div class="card">
        <div class="card-body col-12 col-md-8">
            <form action="{{ route('guests.store') }}" method="POST">
                @csrf
                @method('post')

                <div class="mb-3">
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
                </div>
                <x-text-input name="name" label="Name" required />
                <x-text-input name="phone" label="Phone Number" required />
                <div class="mb-3">
                    <label class="form-label">Destination</label>
                    <select name="destination" class="form-control @error('destination') is-invalid @enderror">
                        <option value="TU" {{ old('destination') == 'TU' ? 'selected' : '' }}>TU
                        </option>
                        <option value="Walikelas" {{ old('destination') == 'Walikelas' ? 'selected' : '' }}>Wali Kelas
                        </option>
                        <option value="Guru" {{ old('destination') == 'Guru' ? 'selected' : '' }}>Guru
                        </option>
                        <option value="Bendahara" {{ old('destination') == 'Bendahara' ? 'selected' : '' }}>Bendahara
                        </option>
                        <option value="Kurikulum" {{ old('destination') == 'Kurikulum' ? 'selected' : '' }}>Kurikulum
                        </option>
                        <option value="Kesiswaan" {{ old('destination') == 'Kesiswaan' ? 'selected' : '' }}>Kesiswaan
                        </option>
                        <option value="Kepala Sekolah" {{ old('destination') == 'Kepala Sekolah' ? 'selected' : '' }}>
                            Kepala
                            Sekolah
                        </option>
                        <option value="Meeting" {{ old('destination') == 'Meeting' ? 'selected' : '' }}>Meeting
                        </option>
                        <option value="Lainnya" {{ old('destination') == 'Lainnya' ? 'selected' : '' }}>Lainnya
                        </option>
                    </select>
                    @error('destination')
                        <div class="invalid-feedback">{{ $message }}</div>
                    @enderror
                </div>
                <x-text-input name="purpose" label="Purpose" required />
                <x-text-input type="time" name="checkin" label="Check In" required />
                <x-text-input type="time" name="Checkout" label="Check Out" />
                <x-text-input name="image" label="image" />
                <div class="mb-3">
                    <label class="form-label">Status</label>
                    <select name="status" class="form-control @error('status') is-invalid @enderror">
                        <option value="Check Out" {{ old('status') == 'Check Out' ? 'selected' : '' }}>Check Out
                        </option>
                        <option value="Still Inside" selected {{ old('status') == 'Still Inside' ? 'selected' : '' }}>Still
                            Inside
                        </option>
                    </select>
                    @error('status')
                        <div class="invalid-feedback">{{ $message }}</div>
                    @enderror
                </div>
                <button type="submit" class="btn btn-primary">Simpan</button>
            </form>
        </div>
    </div>
@endsection
