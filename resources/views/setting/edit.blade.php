@extends('layouts.template-mazer')
@section('content')
    <div class="page-heading">
        <h3>Update Data Setting</h3>
    </div>
    <div class="page-content">
        <div class="card">
            <div class="card-body col-12 col-md-8">
                <form action="{{ route('settings.update', $setting) }}" method="POST">
                    @method('PUT')
                    @csrf
                    <x-text-input name="name" label="Name" required :value="$setting->name" />
                    <x-text-input name="address" label="Address" required :value="$setting->address" />
                    <x-text-input name="logo" label="Logo" required :value="$setting->logo" />
            </div>
            <button type="submit" class="btn btn-primary">Update</button>
            </form>
        </div>
    </div>
    </div>
@endsection
