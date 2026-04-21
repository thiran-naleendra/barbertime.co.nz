@extends('layouts.admin', ['title' => 'Add Product'])

@section('content')
<h1 class="h5 fw-semibold mb-3">Add Product</h1>

@if ($errors->any())
    <div class="alert alert-danger">{{ $errors->first() }}</div>
@endif

<div class="card shadow-sm">
    <div class="card-body">
        <form method="POST" action="{{ route('admin.products.store') }}" enctype="multipart/form-data">
            @csrf
            @include('admin.products.partials.form', ['product' => null])

            <div class="d-flex gap-2">
                <button class="btn btn-dark" type="submit">Save</button>
                <a class="btn btn-outline-secondary" href="{{ route('admin.products.index') }}">Cancel</a>
            </div>
        </form>
    </div>
</div>
@endsection
