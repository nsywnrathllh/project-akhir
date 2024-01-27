@extends('layouts.template-mazer')
@section('content')
<div class="page-heading">
    <h3>Add Data Vehicle</h3>
</div>
<div class="card">
    <div class="card-body col-12 col-md-8">
        <form action="{{ route('vehicles.store') }}" method="POST">
            @csrf
            @method('post')

            <div class="form-group">
                <label for="type">Type</label>
                <select class="form-control" id="type" name="type" required>
                    <option value="motorcycle" selected>Motorcycle</option>
                    <option value="car">Car</option>
                    <option value="bus">Bus</option>
                </select>
                @error('type')
                    <div class="alert alert-light-danger color-danger">{{ $message }}</div>
                @enderror
            </div>
            <x-text-input name="license_plate" label="License Plate" required />
            <button type="submit" class="btn btn-primary">Submit</button>
          </form>
    </div>
</div>
@endsection