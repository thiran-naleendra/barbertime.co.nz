@extends('layouts.admin', ['title' => 'Add Service'])

@section('content')
<h1 class="h5 fw-semibold mb-3">Add Service</h1>

@if ($errors->any())
    <div class="alert alert-danger">{{ $errors->first() }}</div>
@endif

<div class="card shadow-sm">
    <div class="card-body">
        <form method="POST" action="{{ route('admin.services.store') }}" enctype="multipart/form-data">
            @csrf

            @include('admin.services.partials.form', ['service' => null])

            <div class="d-flex gap-2">
                <button class="btn btn-dark" type="submit">Save</button>
                <a class="btn btn-outline-secondary" href="{{ route('admin.services.index') }}">Cancel</a>
            </div>
        </form>
    </div>
</div>
@endsection
