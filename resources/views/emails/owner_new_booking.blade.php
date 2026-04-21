<!doctype html>
<html>
<head>
    <meta charset="utf-8">
</head>
<body style="font-family: Arial, sans-serif; color:#111; line-height:1.6;">

    <h2>New Booking Received 📩</h2>

    <p><strong>Customer:</strong> {{ $booking->customer_name }}</p>
    <p><strong>Email:</strong> {{ $booking->customer_email }}</p>
    <p><strong>Phone:</strong> {{ $booking->customer_phone }}</p>

    <hr style="border:none;border-top:1px solid #ddd;margin:14px 0;">

    <ul style="padding-left:18px;">
        <li>
            <strong>Barber:</strong>
            {{ $booking->barber_name ?: 'No preference' }}
        </li>

        <li>
            <strong>Service:</strong>
            {{ optional($booking->service)->name }}
        </li>

        <li>
            <strong>Date &amp; Time (NZ):</strong>
            {{ $booking->booking_start_at->timezone('Pacific/Auckland')->format('d M Y, h:i A') }}
        </li>

        <li>
            <strong>Status:</strong>
            {{ strtoupper($booking->status) }}
        </li>
    </ul>

    <h3 style="margin: 14px 0 6px;">Payment Summary</h3>

    @php
        $servicePrice = (float)($booking->service?->price ?? 0);
        $fee = (float)$booking->booking_fee;
        $total = $servicePrice + $fee;
    @endphp

    <ul style="padding-left:18px;">
        <li>
            <strong>Service Cost:</strong>
            ${{ number_format($servicePrice, 2) }} {{ $booking->currency }}
        </li>

        <li>
            <strong>Booking Fee:</strong>
            ${{ number_format($fee, 2) }} {{ $booking->currency }}
        </li>

        <li>
            <strong>Total:</strong>
            ${{ number_format($total, 2) }} {{ $booking->currency }}
        </li>
    </ul>

    <p style="margin-top:16px;">
        Login to the admin panel to manage this booking.
    </p>

    <p>
        — <strong>{{ config('app.name') }}</strong>
    </p>

</body>
</html>
