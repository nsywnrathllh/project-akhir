@extends('layouts.template-mazer')
@section('content')
<div class="page-heading">
    <h3>Update Data Vehicle</h3>
</div>
    <div class="page-content">
        <div class="card">
            <div class="card-body col-12 col-md-8">
                <form action="{{ route('vehicles.update', $vehicle)}}" method="POST">
                    @method('PUT')
                    @csrf

                    <div class="mb-3">
                        <label class="form-label">Tipe</label>
                        <select name="type" class="form-control @error('type') is-invalid @enderror">
                            <option value="motorcycle" {{ $vehicle->type == 'motorcycle' ? 'selected' : '' }}>Motorcycle</option>
                            <option value="car" {{ $vehicle->type == 'car' ? 'selected' : '' }}>Car</option>
                            <option value="bus" {{ $vehicle->type == 'bus' ? 'selected' : '' }}>Bus</option>
                        </select>
                        @error('type')
                            <div class="alert alert-light-danger color-danger">{{ $message }}</div>
                        @enderror
                    </div>
                    <x-text-input name="license_plate" label="License Plate" required :value="$vehicle->license_plate" />
                   <button type="submit" class="btn btn-primary">Submit</button>
                </form>
            </div>
        </div>
    </div>
@endsection