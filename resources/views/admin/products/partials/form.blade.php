@php $isEdit = isset($product) && $product; @endphp

<div class="mb-3">
    <label class="form-label">Product Name</label>
    <input class="form-control" name="name" required
           value="{{ old('name', $isEdit ? $product->name : '') }}">
</div>

<div class="mb-3">
    <label class="form-label">Description (optional)</label>
    <textarea class="form-control" name="description" rows="4">{{ old('description', $isEdit ? $product->description : '') }}</textarea>
</div>

<div class="row g-3">
    <div class="col-12 col-md-4">
        <label class="form-label">Price (NZD)</label>
        <input type="number" class="form-control" name="price" step="0.01" min="0" required
               value="{{ old('price', $isEdit ? $product->price : '') }}">
    </div>

    <div class="col-12 col-md-5">
        <label class="form-label">Image (jpg/png/webp)</label>
        <input type="file" class="form-control" name="image" accept="image/*">
        @if($isEdit && $product->image_path)
            <div class="small text-muted mt-2">
                Current:
                <a href="{{ asset('storage/'.$product->image_path) }}" target="_blank">view image</a>
            </div>
        @endif
    </div>

    <div class="col-12 col-md-3 d-flex align-items-end">
        <div class="form-check">
            <input class="form-check-input" type="checkbox" name="is_active" id="is_active"
                   {{ old('is_active', $isEdit ? $product->is_active : true) ? 'checked' : '' }}>
            <label class="form-check-label" for="is_active">Active</label>
        </div>
    </div>
</div>
