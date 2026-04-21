@extends('layouts.admin', ['title' => 'Add Gallery Photo'])

@section('content')
<h1 class="h5 fw-semibold mb-3">Add Gallery Photo</h1>

@if ($errors->any())
    <div class="alert alert-danger">{{ $errors->first() }}</div>
@endif

<div class="card shadow-sm">
    <div class="card-body">
        <form method="POST" action="{{ route('admin.gallery.store') }}" enctype="multipart/form-data">
            @csrf
            @include('admin.gallery.partials.form', ['image' => null])

            <div class="d-flex gap-2">
                <button class="btn btn-dark" type="submit">Save</button>
                <a class="btn btn-outline-secondary" href="{{ route('admin.gallery.index') }}">Cancel</a>
            </div>
        </form>
    </div>
</div>
@endsection
