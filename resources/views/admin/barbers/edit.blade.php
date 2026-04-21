@extends('layouts.admin')

@section('content')
<div class="d-flex justify-content-between align-items-center mb-3">
  <h3>Edit Barber</h3>
</div>

<form method="POST" action="{{ route('admin.barbers.update', $barber) }}" enctype="multipart/form-data">
  @method('PUT')
  @include('admin.barbers.partials.form', ['barber' => $barber])
</form>
@endsection
