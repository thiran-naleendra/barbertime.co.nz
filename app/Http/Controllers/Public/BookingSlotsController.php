<?php

namespace App\Http\Controllers\Public;

use App\Http\Controllers\Controller;
use App\Models\Booking;
use App\Models\Service;
use Illuminate\Http\Request;
use Illuminate\Support\Carbon;

class BookingSlotsController extends Controller
{
    public function index(Request $request)
    {
        try {
            $data = $request->validate([
                'date'       => ['required', 'date_format:Y-m-d'],
                'service_id' => ['required', 'exists:services,id'],
                'barber'     => ['required', 'string', 'max:50'],
            ]);

            $service = Service::findOrFail($data['service_id']);
            $barber  = trim($data['barber']);

            // NZ day range
            $dayStart = Carbon::createFromFormat('Y-m-d', $data['date'], 'Pacific/Auckland')->startOfDay();
            $dayEnd   = $dayStart->copy()->endOfDay();

            // Booked slots PER BARBER
            $booked = Booking::query()
                ->where('service_id', $service->id)
                ->where('barber_name', $barber)
                ->whereBetween('booking_start_at', [
                    $dayStart->copy()->timezone('UTC'),
                    $dayEnd->copy()->timezone('UTC'),
                ])
                ->whereIn('status', ['pending', 'confirmed', 'paid'])
                ->pluck('booking_start_at')
                ->map(fn ($dt) =>
                    Carbon::parse($dt)->timezone('Pacific/Auckland')->format('H:i')
                )
                ->values()
                ->all();

            // Working hours
            $open  = $dayStart->copy()->setTime(9, 0);
            $close = $dayStart->copy()->setTime(18, 0);

            $slots = [];
            $slot  = $open->copy();

            while ($slot->lt($close)) {
                $time = $slot->format('H:i');

                $slots[] = [
                    'time'      => $time,
                    'available' => !in_array($time, $booked),
                ];

                $slot->addMinutes(30);
            }

            return response()->json([
                'slots' => $slots,
            ]);
        } catch (\Throwable $e) {
            // ✅ ALWAYS return JSON (prevents frontend crash)
            return response()->json([
                'slots' => [],
                'error' => 'Slot loading failed',
            ], 200);
        }
    }
}
