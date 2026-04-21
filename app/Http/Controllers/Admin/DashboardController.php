<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Booking;

class DashboardController extends Controller
{
    public function index()
    {
        $user = auth()->user();

        // Admin (role_id = 2) can ONLY see bookings
        if ((int)($user->role_id ?? 0) === 2) {
            return redirect()->route('admin.bookings.index');
        }

        // Super Admin (role_id = 1) sees full dashboard
        $nowNZ = now('Pacific/Auckland')->timezone('UTC'); // convert to UTC for DB compare

        $upcoming = Booking::with('service')
            ->where('booking_start_at', '>=', $nowNZ)
            ->orderBy('booking_start_at')
            ->limit(5)
            ->get();

        return view('admin.dashboard', compact('upcoming'));
    }
}
