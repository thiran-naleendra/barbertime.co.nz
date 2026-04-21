@extends('layouts.admin')

@section('content')
<div class="d-flex justify-content-between align-items-center mb-3">
  <h3>Add Barber</h3>
</div>

<form method="POST" action="{{ route('admin.barbers.store') }}" enctype="multipart/form-data">
  @include('admin.barbers.partials.form')
</form>
@endsection
