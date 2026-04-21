<?php

namespace App\Http\Controllers\Public;

use App\Http\Controllers\Controller;
use App\Models\Booking;
use App\Models\Service;
use App\Models\Barber; // ✅ NEW
use Illuminate\Http\Request;
use Illuminate\Support\Carbon;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Mail;
use Illuminate\Validation\Rule;

use App\Mail\CustomerBookingSubmittedMail;
use App\Mail\OwnerNewBookingMail;

class BookingController extends Controller
{
    public function create()
    {
        $services   = Service::where('is_active', true)->orderBy('name')->get();
        $bookingFee = 10.00;

        // ✅ IMPORTANT CHANGE:
        // Get barbers from DB so each barber has name + image_path (and image_url accessor)
        $barbers = Barber::where('is_active', true)
            ->orderBy('sort_order')
            ->orderBy('name')
            ->get();

        return view('public.booking.form', compact(
            'services',
            'bookingFee',
            'barbers'
        ));
    }

    public function store(Request $request)
    {
        $data = $request->validate([
            'service_id'     => ['required', 'exists:services,id'],
            'barber_name'    => [
                'required',
                'string',
                'max:50',
                Rule::exists('barbers', 'name')->where(fn ($query) => $query->where('is_active', true)),
            ],
            'date'           => ['required', 'date'],
            'time'           => ['required', 'date_format:H:i'],
            'customer_name'  => ['required', 'string', 'max:255'],
            'customer_email' => ['required', 'email', 'max:255'],
            'customer_phone' => ['required', 'string', 'max:30'],
            'notes'          => ['nullable', 'string', 'max:2000'],
            'agree_policies' => ['accepted'],
        ]);

        $service = Service::findOrFail($data['service_id']);
        $barber = Barber::query()
            ->where('name', trim($data['barber_name']))
            ->where('is_active', true)
            ->firstOrFail();

        // Combine date + time (NZ)
        $nzDateTime = Carbon::createFromFormat(
            'Y-m-d H:i',
            $data['date'].' '.$data['time'],
            'Pacific/Auckland'
        );

        if ($nzDateTime->isPast()) {
            return back()
                ->withErrors(['date' => 'Booking date/time must be in the future.'])
                ->withInput();
        }

        $workStart = Carbon::createFromFormat(
            'Y-m-d H:i',
            $data['date'].' '.substr((string) $barber->work_start_time, 0, 5),
            'Pacific/Auckland'
        );
        $workEnd = Carbon::createFromFormat(
            'Y-m-d H:i',
            $data['date'].' '.substr((string) $barber->work_end_time, 0, 5),
            'Pacific/Auckland'
        );
        $durationMinutes = max(30, (int) ($service->duration_minutes ?: 30));
        $bookingEnd = $nzDateTime->copy()->addMinutes($durationMinutes);

        if ($nzDateTime->lt($workStart) || $bookingEnd->gt($workEnd)) {
            return back()
                ->withErrors([
                    'time' => sprintf(
                        '%s is available between %s and %s only.',
                        $barber->name,
                        substr((string) $barber->work_start_time, 0, 5),
                        substr((string) $barber->work_end_time, 0, 5),
                    ),
                ])
                ->withInput();
        }

        // Store as UTC
        $utcDateTime = $nzDateTime->copy()->timezone('UTC');

        $booking = DB::transaction(function () use ($data, $utcDateTime) {

            $alreadyBooked = Booking::query()
                ->where('barber_name', $data['barber_name'])
                ->where('booking_start_at', $utcDateTime)
                ->whereIn('status', ['pending', 'paid', 'confirmed'])
                ->lockForUpdate()
                ->exists();

            if ($alreadyBooked) {
                return null;
            }

            return Booking::create([
                'service_id'       => $data['service_id'],
                'barber_name'      => $data['barber_name'],
                'customer_name'    => $data['customer_name'],
                'customer_email'   => $data['customer_email'],
                'customer_phone'   => $data['customer_phone'],
                'booking_start_at' => $utcDateTime,
                'notes'            => $data['notes'],
                'status'           => 'pending',
                'booking_fee'      => 10.00,
                'currency'         => 'NZD',
            ]);
        });

        if (!$booking) {
            return back()
                ->withErrors(['time' => 'Sorry, this barber is already booked at this time.'])
                ->withInput();
        }

        $booking->load('service');

        Mail::to($booking->customer_email)
            ->send(new CustomerBookingSubmittedMail($booking));

        if ($owner = env('SALON_OWNER_EMAIL')) {
            Mail::to($owner)->send(new OwnerNewBookingMail($booking));
        }

        return redirect()->route('book.success', $booking);
    }

    public function success(Booking $booking)
    {
        $booking->load('service');
        return view('public.booking.success', compact('booking'));
    }
}
