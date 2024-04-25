@extends('layouts.template-mazer')
@section('content')
@notifyCss
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
                    <x-textarea-input name="address" label="Address" required :value="$setting->address" />
                    <div class="row">
                        <div class="mb-3">
                            <a href="{{ asset('logo/logo.png') }}">
                                <img style="max-width: 150px; max-height: 100px;" src="{{ asset('logo/' . $setting->logo) }}" alt="Logo" title="click to view">
                            </a>
                            <x-text-input type="file" name="logo" label="Logo" :value="$setting->logo" />
                        </div>
                    </div>
                    <x-text-input name="wa_endpoint" label="WA Endpoint" required :value="$setting->wa_endpoint" />
                    <x-text-input name="wa_api_key" label="WA API Key" required :value="$setting->wa_api_key" />
                    <x-text-input name="wa_sender" label="WA Sender" required :value="$setting->wa_sender" />
                    <input type="submit" value="Simpan" class="btn btn-primary" style="background-color: rgb(66, 66, 221);" id="btnSubmit">
                </form>
            </div>
        </div>
    </div>
    <x-notify::notify />
@notifyJs
@endsection
