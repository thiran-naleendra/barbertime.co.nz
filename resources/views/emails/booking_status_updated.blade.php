<!doctype html>
<html>
<head>
    <meta charset="utf-8">
</head>
<body style="font-family: Arial, sans-serif; color:#111; line-height:1.6;">
    <h2>Booking Status Update</h2>

    <p>Hi {{ $booking->customer_name }},</p>

    <p>
        Your booking status has been updated from
        <strong>{{ strtoupper($oldStatus) }}</strong> to
        <strong>{{ strtoupper($booking->status) }}</strong>.
    </p>

    <ul style="padding-left:18px;">
        <li>
            <strong>Service:</strong>
            {{ optional($booking->service)->name }}
        </li>

        <li>
            <strong>Barber:</strong>
            {{ $booking->barber_name ?: 'No preference' }}
        </li>

        <li>
            <strong>Date &amp; Time (NZ):</strong>
            {{ $booking->booking_start_at->timezone('Pacific/Auckland')->format('d M Y, h:i A') }}
        </li>

        <li>
            <strong>Booking Fee:</strong>
            ${{ number_format((float)$booking->booking_fee, 2) }} {{ $booking->currency }}
        </li>
    </ul>

    <p>
        If you have any questions, please reply to this email.
    </p>

    <p>
        Thank you,<br>
        <strong>{{ config('app.name') }}</strong>
    </p>
</body>
</html>
