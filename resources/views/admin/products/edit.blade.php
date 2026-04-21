@extends('layouts.admin', ['title' => 'Edit Product'])

@section('content')
<h1 class="h5 fw-semibold mb-3">Edit Product</h1>

@if ($errors->any())
    <div class="alert alert-danger">{{ $errors->first() }}</div>
@endif

<div class="card shadow-sm">
    <div class="card-body">
        <form method="POST" action="{{ route('admin.products.update', $product) }}" enctype="multipart/form-data">
            @csrf
            @method('PUT')

            @include('admin.products.partials.form', ['product' => $product])

            <div class="d-flex gap-2">
                <button class="btn btn-dark" type="submit">Update</button>
                <a class="btn btn-outline-secondary" href="{{ route('admin.products.index') }}">Cancel</a>
            </div>
        </form>
    </div>
</div>
@endsection
