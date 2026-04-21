@extends('layouts.public', ['title' => 'Booking Submitted'])

@section('content')
    <div class="card shadow-sm">
        <div class="card-body p-4">

            <h1 class="h5 fw-semibold mb-2">Booking Submitted ✅</h1>

            <p class="text-muted mb-4">
                Your booking request is saved as
                <strong>{{ strtoupper($booking->status) }}</strong>.
                We will contact you soon.
            </p>

            @php
                // Support both single-service and multi-service bookings
                $services = $booking->services ?? collect(optional($booking->service));
                $servicesTotal = $services->sum(function ($s) {
                    return $s->pivot->price ?? ($s->price ?? 0);
                });

                $bookingFee = $booking->booking_fee ?? 0;
                $grandTotal = $servicesTotal + $bookingFee;

                $barber = $booking->barber_name ?? null;
            @endphp

            <ul class="list-group mb-4">

                {{-- SERVICES --}}
                <li class="list-group-item">
                    <div class="fw-semibold mb-2">Services</div>

                    @foreach ($services as $service)
                        <div class="d-flex justify-content-between small">
                            <span>{{ $service->name }}</span>
                            <strong>
                                ${{ number_format($service->pivot->price ?? $service->price, 2) }}
                            </strong>
                        </div>
                    @endforeach
                </li>

                {{-- DATE --}}
                <li class="list-group-item d-flex justify-content-between">
                    <span>Date & Time</span>
                    <strong>
                        {{ $booking->booking_start_at->timezone('Pacific/Auckland')->format('d M Y, h:i A') }}
                    </strong>
                </li>

                {{-- BARBER --}}
                <li class="list-group-item d-flex justify-content-between">
                    <span>Barber</span>
                    <strong>{{ $barber ?: 'No preference' }}</strong>
                </li>

                {{-- SERVICES TOTAL --}}
                <li class="list-group-item d-flex justify-content-between">
                    <span>Services Total</span>
                    <strong>
                        @if ($servicesTotal > 0)
                            ${{ number_format($servicesTotal, 2) }} {{ $booking->currency }}
                        @else
                            To be confirmed at salon
                        @endif
                    </strong>
                </li>


                {{-- BOOKING FEE --}}
                <li class="list-group-item d-flex justify-content-between">
                    <span>Booking Fee</span>
                    <strong>
                        ${{ number_format($bookingFee, 2) }} {{ $booking->currency }}
                    </strong>
                </li>

                {{-- GRAND TOTAL --}}
                <li class="list-group-item d-flex justify-content-between fw-semibold">
                    <span>Total Amount</span>
                    <strong>
                        ${{ number_format($grandTotal, 2) }} {{ $booking->currency }}
                    </strong>
                </li>

            </ul>

            <a href="{{ route('home') }}" class="btn btn-dark">
                Back to Home
            </a>

        </div>
    </div>
@endsection
