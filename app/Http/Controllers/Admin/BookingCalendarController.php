<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Booking;
use Illuminate\Http\Request;

class BookingCalendarController extends Controller
{
    public function events(Request $request)
    {
        // FullCalendar sends start/end in query string
        $start = $request->query('start');
        $end   = $request->query('end');

        $bookings = Booking::with('service')
            ->when($start, fn($q) => $q->where('booking_start_at', '>=', $start))
            ->when($end, fn($q) => $q->where('booking_start_at', '<=', $end))
            ->whereIn('status', ['pending','confirmed','paid'])
            ->orderBy('booking_start_at')
            ->get();

        return response()->json(
            $bookings->map(function ($b) {
                return [
                    'id'    => $b->id,
                    'title' => ($b->service?->name ?? 'Booking') . ' (#' . $b->id . ')',
                    'start' => $b->booking_start_at->toIso8601String(),
                    // optional: if you have duration, you can set end
                    // 'end' => $b->booking_start_at->copy()->addMinutes($b->service?->duration_minutes ?? 30)->toIso8601String(),
                    'url'   => route('admin.bookings.show', $b),
                ];
            })
        );
    }
}
