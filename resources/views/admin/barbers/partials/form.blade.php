@csrf

<div class="mb-3">
  <label class="form-label">Barber Name</label>
  <input type="text" name="name" class="form-control"
         value="{{ old('name', $barber->name ?? '') }}" required>
  @error('name') <div class="text-danger small">{{ $message }}</div> @enderror
</div>

<div class="mb-3">
  <label class="form-label">Image</label>
  <input type="file" name="image" class="form-control" accept="image/*">
  @error('image') <div class="text-danger small">{{ $message }}</div> @enderror

  @if(!empty($barber) && $barber->image_url)
    <div class="mt-2">
      <img src="{{ $barber->image_url }}" style="height:80px;border-radius:10px;">
    </div>
  @endif
</div>

<div class="row">
  <div class="col-md-6 mb-3">
    <label class="form-label">Sort Order</label>
    <input type="number" name="sort_order" class="form-control"
           value="{{ old('sort_order', $barber->sort_order ?? 0) }}" min="0">
    @error('sort_order') <div class="text-danger small">{{ $message }}</div> @enderror
  </div>

  <div class="col-md-6 mb-3 d-flex align-items-end">
    <div class="form-check">
      <input class="form-check-input" type="checkbox" name="is_active" value="1"
             {{ old('is_active', ($barber->is_active ?? true)) ? 'checked' : '' }}>
      <label class="form-check-label">Active</label>
    </div>
  </div>
</div>

<div class="row">
  <div class="col-md-6 mb-3">
    <label class="form-label">Work Start Time</label>
    <input type="time" name="work_start_time" class="form-control"
           value="{{ old('work_start_time', isset($barber) ? substr((string) $barber->work_start_time, 0, 5) : '09:00') }}"
           required>
    @error('work_start_time') <div class="text-danger small">{{ $message }}</div> @enderror
  </div>

  <div class="col-md-6 mb-3">
    <label class="form-label">Work End Time</label>
    <input type="time" name="work_end_time" class="form-control"
           value="{{ old('work_end_time', isset($barber) ? substr((string) $barber->work_end_time, 0, 5) : '18:00') }}"
           required>
    @error('work_end_time') <div class="text-danger small">{{ $message }}</div> @enderror
  </div>
</div>

<button class="btn btn-primary">Save</button>
<a href="{{ route('admin.barbers.index') }}" class="btn btn-secondary">Cancel</a>
