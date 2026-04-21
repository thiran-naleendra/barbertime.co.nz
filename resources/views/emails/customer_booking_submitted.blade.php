<!doctype html>
<html>
<head>
    <meta charset="utf-8">
</head>
<body style="font-family: Arial, sans-serif; color:#111; line-height:1.6;">

    <h2>Booking Request Received ✅</h2>

    <p>Hi {{ $booking->customer_name }},</p>

    <p>
        We’ve received your booking request.
        Our team will review it and confirm your appointment shortly.
    </p>

    @php
        // Support single or multi-service bookings
        $services = $booking->services ?? collect(optional($booking->service));

        // Sum up service prices (0 if missing)
        $servicesTotal = $services->sum(function ($s) {
            return $s->pivot->price ?? $s->price ?? 0;
        });

        $bookingFee = $booking->booking_fee ?? 0;
        $grandTotal = $servicesTotal + $bookingFee;

        // If any service is "Custom Package", we treat pricing as TBC
        $hasCustomPackage = $services->contains(function ($s) {
            return ($s->name ?? '') === 'Custom Package';
        });

        // Also treat as TBC if total is 0 (e.g. all services are unpriced)
        $isTbc = $hasCustomPackage || $servicesTotal <= 0;
    @endphp

    <ul style="padding-left:18px;">
        <li>
            <strong>Barber:</strong>
            {{ $booking->barber_name ?: 'No preference' }}
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

    <hr style="border:none;border-top:1px solid #ddd;margin:16px 0;">

    <h3 style="margin: 10px 0;">Payment Summary</h3>

    <table cellpadding="6" cellspacing="0"
           style="border-collapse: collapse; width:100%; max-width:520px;">

        {{-- SERVICES --}}
        @foreach($services as $service)
            @php
                $price = $service->pivot->price ?? $service->price ?? 0;
                $isServiceTbc = (($service->name ?? '') === 'Custom Package') || ((float)$price <= 0);
            @endphp
            <tr>
                <td style="border:1px solid #ddd;">
                    {{ $service->name }}
                </td>
                <td style="border:1px solid #ddd; text-align:right;">
                    @if ($isServiceTbc)
                        To be confirmed at salon
                    @else
                        ${{ number_format((float)$price, 2) }} {{ $booking->currency }}
                    @endif
                </td>
            </tr>
        @endforeach

        {{-- SERVICES TOTAL --}}
        <tr>
            <td style="border:1px solid #ddd;">
                <strong>Services Total</strong>
            </td>
            <td style="border:1px solid #ddd; text-align:right;">
                <strong>
                    @if ($isTbc)
                        To be confirmed at salon
                    @else
                        ${{ number_format((float)$servicesTotal, 2) }} {{ $booking->currency }}
                    @endif
                </strong>
            </td>
        </tr>

        {{-- BOOKING FEE --}}
        <tr>
            <td style="border:1px solid #ddd;">
                Booking Fee
            </td>
            <td style="border:1px solid #ddd; text-align:right;">
                ${{ number_format((float)$bookingFee, 2) }} {{ $booking->currency }}
            </td>
        </tr>

        {{-- GRAND TOTAL --}}
        <tr>
            <td style="border:1px solid #ddd;">
                <strong>Total Amount</strong>
            </td>
            <td style="border:1px solid #ddd; text-align:right;">
                <strong>
                    @if ($isTbc)
                        To be confirmed at salon
                    @else
                        ${{ number_format((float)$grandTotal, 2) }} {{ $booking->currency }}
                    @endif
                </strong>
            </td>
        </tr>
    </table>

    <p style="margin-top:16px;">
        If you need to change your booking, please reply to this email or contact us.
    </p>

    <p>
        Thank you,<br>
        <strong>{{ config('app.name') }}</strong>
    </p>

</body>
</html>
