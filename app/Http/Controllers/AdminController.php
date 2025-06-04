<?php

namespace App\Http\Controllers;

use App\Models\Booking;
use App\Models\Bungalow;
use App\Models\User;
use Illuminate\Http\Request;

class AdminController extends Controller
{
    public function dashboard()
    {
        // Fetch statistics for the overview cards
        $totalBookings = Booking::count();
        $totalUsers = User::count();
        $activeBungalows = Bungalow::count();

        // Fetch bookings categorized by their status
        $paidBookings = Booking::with(['user', 'bungalow'])
                               ->where('status', 'paid')
                               ->latest()
                               ->get();

        $pendingBookings = Booking::with(['user', 'bungalow'])
                                 ->where('status', 'pending')
                                 ->latest()
                                 ->get();

        $cancelledBookings = Booking::with(['user', 'bungalow'])
                                   ->where('status', 'cancelled')
                                   ->latest()
                                   ->get();

        // Ensure these are passed to the view using compact()
        return view('admin.dashboard', compact(
            'totalBookings',
            'activeBungalows',
            'totalUsers',
            'paidBookings',
            'pendingBookings',
            'cancelledBookings'
        ));
    }
}
