<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use App\Models\Booking; // Make sure this is imported
use App\Models\Message; // Import the Message model

class DashboardController extends Controller
{
    /**
     * Display the user's dashboard with bookings and messages.
     */
    public function index()
    {
        $user = Auth::user();

        // Fetch user's bookings, ordered by creation date
        $userBookings = $user->bookings()->with('bungalow')->orderBy('created_at', 'desc')->get();

        // Fetch user's received messages, ordered by creation date, with sender info
        $receivedMessages = $user->receivedMessages()->with('sender')->orderBy('created_at', 'desc')->get();

        // Count unread messages
        $unreadMessagesCount = $user->receivedMessages()->whereNull('read_at')->count();

        return view('dashboard', compact('userBookings', 'receivedMessages', 'unreadMessagesCount'));
    }
}
