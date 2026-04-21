@php
    $isEdit = isset($service) && $service;
@endphp

<div class="mb-3">
    <label class="form-label">Service Name</label>
    <input type="text"
           class="form-control"
           name="name"
           value="{{ old('name', $isEdit ? $service->name : '') }}"
           required>
</div>

<div class="mb-3">
    <label class="form-label">Description (optional)</label>
    <textarea class="form-control"
              name="description"
              rows="4">{{ old('description', $isEdit ? $service->description : '') }}</textarea>
</div>

<div class="row g-3">
    <div class="col-12 col-md-4">
        <label class="form-label">Price (NZD)</label>
        <input type="number"
               class="form-control"
               name="price"
               step="0.01"
               min="0"
               value="{{ old('price', $isEdit ? $service->price : '') }}"
               required>
    </div>

    <div class="col-12 col-md-4">
        <label class="form-label">Duration (minutes)</label>
        <input type="number"
               class="form-control"
               name="duration_minutes"
               min="1"
               value="{{ old('duration_minutes', $isEdit ? $service->duration_minutes : '') }}">
    </div>

    <div class="col-12 col-md-4 d-flex align-items-end">
        <div class="form-check">
            <input class="form-check-input"
                   type="checkbox"
                   name="is_active"
                   id="is_active"
                   {{ old('is_active', $isEdit ? $service->is_active : true) ? 'checked' : '' }}>
            <label class="form-check-label" for="is_active">
                Active (show on website)
            </label>
        </div>
    </div>
</div>

{{-- ✅ IMAGE --}}
<div class="mt-4">
    <label class="form-label">Service Image (optional)</label>
    <input type="file"
           class="form-control"
           name="image"
           accept="image/*">

    @if ($isEdit && $service->image_path)
        <div class="mt-3">
            <div class="fw-semibold mb-1">Current Image</div>
            <img src="{{ Storage::url($service->image_path) }}"
                 alt="{{ $service->name }}"
                 class="rounded border shadow-sm"
                 style="max-width:220px; height:auto;">
        </div>
    @endif
</div>
