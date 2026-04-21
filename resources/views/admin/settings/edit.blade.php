@extends('layouts.admin', ['title' => 'Settings'])

@section('content')
<div class="d-flex justify-content-between align-items-center mb-3">
    <h1 class="h5 fw-semibold mb-0">Settings</h1>
</div>

@if(session('success'))
    <div class="alert alert-success">{{ session('success') }}</div>
@endif

@if ($errors->any())
    <div class="alert alert-danger">{{ $errors->first() }}</div>
@endif

<div class="card shadow-sm">
    <div class="card-body">
        <form method="POST" action="{{ route('admin.settings.update') }}">
            @csrf

            <div class="mb-3">
                <label class="form-label">Salon Name</label>
                <input type="text" name="salon_name" class="form-control"
                       value="{{ old('salon_name', $settings['salon_name']) }}">
            </div>

            <div class="row g-3">
                <div class="col-12 col-md-4">
                    <label class="form-label">Phone</label>
                    <input type="text" name="contact_phone" class="form-control"
                           value="{{ old('contact_phone', $settings['contact_phone']) }}">
                </div>

                <div class="col-12 col-md-4">
                    <label class="form-label">Email</label>
                    <input type="email" name="contact_email" class="form-control"
                           value="{{ old('contact_email', $settings['contact_email']) }}">
                </div>

                <div class="col-12 col-md-4">
                    <label class="form-label">Address</label>
                    <input type="text" name="contact_address" class="form-control"
                           value="{{ old('contact_address', $settings['contact_address']) }}">
                </div>
            </div>

            <div class="mt-3">
                <label class="form-label">Google Map Embed Code</label>
                <textarea name="map_embed" class="form-control" rows="6"
                          placeholder="Paste Google Maps iframe embed code here">{{ old('map_embed', $settings['map_embed']) }}</textarea>
                <div class="small text-muted mt-2">
                    Google Maps → Share → Embed a map → Copy HTML (iframe) and paste here.
                </div>
            </div>

            <button class="btn btn-dark mt-3" type="submit">Save Settings</button>
        </form>
    </div>
</div>

@if(!empty($settings['map_embed']))
    <div class="card shadow-sm mt-3">
        <div class="card-body">
            <div class="fw-semibold mb-2">Map Preview</div>
            <div class="ratio ratio-16x9">
                {!! $settings['map_embed'] !!}
            </div>
        </div>
    </div>
@endif
@endsection
