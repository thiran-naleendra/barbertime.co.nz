@extends('layouts.admin', ['title' => 'Booking Details'])

@section('content')
<div class="d-flex justify-content-between align-items-center mb-3">
    <h1 class="h5 fw-semibold mb-0">Booking Details</h1>
    <a href="{{ route('admin.bookings.index') }}" class="btn btn-outline-secondary btn-sm">Back</a>
</div>

@if(session('success'))
    <div class="alert alert-success">{{ session('success') }}</div>
@endif

@if ($errors->any())
    <div class="alert alert-danger">{{ $errors->first() }}</div>
@endif

<!-- Status Update Card -->
<div class="card shadow-sm mb-3">
    <div class="card-body">
        <form method="POST" action="{{ route('admin.bookings.status', $booking) }}" class="row g-2 align-items-end">
            @csrf
            @method('PATCH')

            <div class="col-12 col-md-6">
                <label class="form-label">Update Status</label>
                <select name="status" class="form-select" required>
                    <option value="pending"   {{ $booking->status === 'pending' ? 'selected' : '' }}>Pending</option>
                    <option value="paid"      {{ $booking->status === 'paid' ? 'selected' : '' }}>Paid</option>
                    <option value="confirmed" {{ $booking->status === 'confirmed' ? 'selected' : '' }}>Confirmed</option>
                    <option value="cancelled" {{ $booking->status === 'cancelled' ? 'selected' : '' }}>Cancelled</option>
                </select>
            </div>

            <div class="col-12 col-md-3">
                <button class="btn btn-dark w-100" type="submit">Update</button>
            </div>
        </form>

        <div class="small text-muted mt-2">
            Booking fee: <strong>${{ number_format((float)$booking->booking_fee, 2) }} {{ $booking->currency }}</strong>
        </div>
    </div>
</div>

<!-- Booking details -->
<div class="card shadow-sm">
    <div class="card-body">
        <ul class="list-group">
            <li class="list-group-item d-flex justify-content-between">
                <span>Service</span>
                <strong>{{ optional($booking->service)->name }}</strong>
            </li>
            <li class="list-group-item d-flex justify-content-between">
                <span>Date & Time (NZ)</span>
                <strong>{{ $booking->booking_start_at->timezone('Pacific/Auckland')->format('d M Y, h:i A') }}</strong>
            </li>
            <li class="list-group-item d-flex justify-content-between">
                <span>Customer</span>
                <strong>{{ $booking->customer_name }}</strong>
            </li>
            <li class="list-group-item d-flex justify-content-between">
                <span>Email</span>
                <strong>{{ $booking->customer_email }}</strong>
            </li>
            <li class="list-group-item d-flex justify-content-between">
                <span>Phone</span>
                <strong>{{ $booking->customer_phone }}</strong>
            </li>
            <li class="list-group-item d-flex justify-content-between">
                <span>Status</span>
                <strong>{{ strtoupper($booking->status) }}</strong>
            </li>
            <li class="list-group-item d-flex justify-content-between">
                <span>Booking Fee</span>
                <strong>${{ number_format((float)$booking->booking_fee, 2) }} {{ $booking->currency }}</strong>
            </li>
        </ul>

        @if($booking->notes)
            <div class="mt-3">
                <div class="fw-semibold">Notes</div>
                <div class="text-muted">{{ $booking->notes }}</div>
            </div>
        @endif
    </div>
</div>
@endsection
