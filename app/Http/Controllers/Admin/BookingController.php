<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Booking;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Mail;
use App\Mail\BookingStatusUpdatedMail;


class BookingController extends Controller
{
    public function index(Request $request)
    {
        $q = $request->q;
        $status = $request->status;
        $date = $request->date;

        $bookings = Booking::with('service')
            ->when($q, function ($query) use ($q) {
                $query->where(function ($qq) use ($q) {
                    $qq->where('customer_name', 'like', "%$q%")
                        ->orWhere('customer_email', 'like', "%$q%")
                        ->orWhere('customer_phone', 'like', "%$q%");
                });
            })
            ->when($status, fn($q2) => $q2->where('status', $status))
            ->when($date, fn($q3) => $q3->whereDate('booking_start_at', $date))
            ->orderByDesc('booking_start_at')
            ->paginate(10);

        return view('admin.bookings.index', compact('bookings'));
    }


    public function show(Booking $booking)
    {
        $booking->load('service');
        return view('admin.bookings.show', compact('booking'));
    }
    public function updateStatus(Request $request, Booking $booking)
    {
        $data = $request->validate([
            'status' => ['required', 'in:pending,paid,confirmed,cancelled'],
        ]);

        $oldStatus = $booking->status;

        // Update status
        $booking->update(['status' => $data['status']]);

        // Load service for email template
        $booking->load('service');

        // Send email only if status actually changed
        if ($oldStatus !== $booking->status) {
            Mail::to($booking->customer_email)->send(new BookingStatusUpdatedMail($booking, $oldStatus));
        }

        return redirect()
            ->route('admin.bookings.show', $booking)
            ->with('success', 'Booking status updated successfully (email sent to customer).');
    }
}
