<?php

namespace App\Http\Controllers\Public;

use App\Http\Controllers\Controller;
use App\Models\Barber;
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
            $barber = Barber::query()
                ->where('name', trim($data['barber']))
                ->where('is_active', true)
                ->firstOrFail();

            // NZ day range
            $dayStart = Carbon::createFromFormat('Y-m-d', $data['date'], 'Pacific/Auckland')->startOfDay();
            $dayEnd   = $dayStart->copy()->endOfDay();
            $durationMinutes = max(30, (int) ($service->duration_minutes ?: 30));

            // Booked slots PER BARBER
            $booked = Booking::query()
                ->where('barber_name', $barber->name)
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

            [$openHour, $openMinute] = array_map('intval', explode(':', substr((string) $barber->work_start_time, 0, 5)));
            [$closeHour, $closeMinute] = array_map('intval', explode(':', substr((string) $barber->work_end_time, 0, 5)));

            $open  = $dayStart->copy()->setTime($openHour, $openMinute);
            $close = $dayStart->copy()->setTime($closeHour, $closeMinute);

            $slots = [];
            $slot  = $open->copy();
            $latestStart = $close->copy()->subMinutes($durationMinutes);

            while ($slot->lte($latestStart)) {
                $time = $slot->format('H:i');

                $slots[] = [
                    'time'      => $time,
                    'available' => !in_array($time, $booked),
                ];

                $slot->addMinutes(30);
            }

            return response()->json([
                'slots' => $slots,
                'working_hours' => [
                    'start' => $open->format('H:i'),
                    'end' => $close->format('H:i'),
                    'label' => $barber->working_hours_label,
                ],
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
