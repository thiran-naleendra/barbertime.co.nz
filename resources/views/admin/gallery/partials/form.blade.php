@php $isEdit = isset($image) && $image; @endphp

<div class="row g-3">
    <div class="col-12 col-md-6">
        <label class="form-label">Title (optional)</label>
        <input class="form-control" name="title"
               value="{{ old('title', $isEdit ? $image->title : '') }}">
    </div>

    <div class="col-12 col-md-3">
        <label class="form-label">Sort Order</label>
        <input type="number" class="form-control" name="sort_order" min="0"
               value="{{ old('sort_order', $isEdit ? $image->sort_order : 0) }}">
    </div>

    <div class="col-12 col-md-3 d-flex align-items-end">
        <div class="form-check">
            <input class="form-check-input" type="checkbox" name="is_active" id="is_active"
                   {{ old('is_active', $isEdit ? $image->is_active : true) ? 'checked' : '' }}>
            <label class="form-check-label" for="is_active">Active</label>
        </div>
    </div>
</div>

<div class="mt-3">
    <label class="form-label">{{ $isEdit ? 'Replace Image (optional)' : 'Image (required)' }}</label>
    <input type="file" class="form-control" name="image" accept="image/*" {{ $isEdit ? '' : 'required' }}>

    @if($isEdit)
        <div class="small text-muted mt-2">
            Current:
            <a href="{{ asset('storage/'.$image->image_path) }}" target="_blank">view image</a>
        </div>
    @endif
</div>
