@extends('layouts.admin', ['title' => 'Gallery'])

@section('content')
<div class="d-flex align-items-center justify-content-between mb-3">
    <h1 class="h5 fw-semibold mb-0">Gallery</h1>
    <a class="btn btn-dark btn-sm" href="{{ route('admin.gallery.create') }}">+ Add Photo</a>
</div>

@if(session('success'))
    <div class="alert alert-success">{{ session('success') }}</div>
@endif

<div class="row g-3">
@forelse($images as $img)
    <div class="col-12 col-md-6 col-lg-3">
        <div class="border rounded-3 overflow-hidden bg-white h-100">
            <img src="{{ asset('storage/'.$img->image_path) }}" style="width:100%;height:160px;object-fit:cover;">
            <div class="p-3">
                <div class="fw-semibold">{{ $img->title ?? '—' }}</div>
                <div class="small text-muted">Sort: {{ $img->sort_order }}</div>
                <div class="mt-2 d-flex gap-2">
                    <a class="btn btn-outline-primary btn-sm" href="{{ route('admin.gallery.edit', $img) }}">Edit</a>

                    <form method="POST" action="{{ route('admin.gallery.destroy', $img) }}"
                          onsubmit="return confirm('Delete this photo?')">
                        @csrf
                        @method('DELETE')
                        <button class="btn btn-outline-danger btn-sm" type="submit">Delete</button>
                    </form>

                    @if($img->is_active)
                        <span class="badge text-bg-success ms-auto align-self-center">Active</span>
                    @else
                        <span class="badge text-bg-secondary ms-auto align-self-center">Hidden</span>
                    @endif
                </div>
            </div>
        </div>
    </div>
@empty
    <div class="col-12"><div class="alert alert-info mb-0">No gallery photos yet.</div></div>
@endforelse
</div>

<div class="mt-3">
    {{ $images->links() }}
</div>
@endsection
