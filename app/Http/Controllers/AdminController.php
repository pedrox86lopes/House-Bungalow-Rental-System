<?php

namespace App\Http\Controllers;

use App\Models\Booking; // Make sure to import your Booking model
use Illuminate\Http\Request;

class AdminController extends Controller
{
    public function dashboard()
    {
        // Fetch all bookings, eager load bungalow and user details
        $bookings = Booking::with(['bungalow', 'user'])
                            ->orderBy('created_at', 'desc')
                            ->get();

        return view('admin.dashboard', compact('bookings'));
    }
}
