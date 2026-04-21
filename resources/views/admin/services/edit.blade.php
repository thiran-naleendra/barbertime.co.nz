@extends('layouts.admin', ['title' => 'Edit Service'])

@section('content')
<h1 class="h5 fw-semibold mb-3">Edit Service</h1>

@if ($errors->any())
    <div class="alert alert-danger">{{ $errors->first() }}</div>
@endif

<div class="card shadow-sm">
    <div class="card-body">
        <form method="POST" action="{{ route('admin.services.update', $service) }}" enctype="multipart/form-data">
            @csrf
            @method('PUT')

            @include('admin.services.partials.form', ['service' => $service])

            <div class="d-flex gap-2">
                <button class="btn btn-dark" type="submit">Update</button>
                <a class="btn btn-outline-secondary" href="{{ route('admin.services.index') }}">Cancel</a>
            </div>
        </form>
    </div>
</div>
@endsection
