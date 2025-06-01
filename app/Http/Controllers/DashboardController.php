<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use App\Models\Booking;
use App\Models\Message;
use App\Models\User; // Import the User model

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

        // Fetch the CURRENTLY AUTHENTICATED USER'S received messages, ordered by creation date, with sender info
        // This variable is always needed for the regular user's message section.
        $receivedMessages = $user->receivedMessages()->with('sender')->orderBy('created_at', 'desc')->get();

        // Count unread messages for the currently authenticated user
        $unreadMessagesCount = $user->receivedMessages()->whereNull('read_at')->count();

        // --- Logic for Admin Specific Messages ---
        $adminEmail = config('app.admin_email');
        $adminUser = User::where('email', $adminEmail)->first();

        $adminMessages = collect(); // Initialize an empty collection for admin messages

        // Only fetch admin messages if the admin user exists in the database
        if ($adminUser) {
            // Check if the currently authenticated user IS the admin
            // If the authenticated user IS the admin, they will see their own messages
            // which are also the "admin messages".
            // If you want to show a separate "admin dashboard" for the admin's inbox,
            // and the admin also has their own "user inbox", then this logic is fine.
            // However, typically, the admin IS the user whose email is the admin email.
            // So, $adminMessages might just be $receivedMessages if the user is the admin.
            // To ensure it's specifically for THE admin email, we explicitly fetch it here.
            $adminMessages = $adminUser->receivedMessages()->with('sender')->orderBy('created_at', 'desc')->get();
        }
        // --- End of Admin Specific Messages Logic ---

        return view('dashboard', compact('userBookings', 'receivedMessages', 'unreadMessagesCount', 'adminMessages'));
    }
}
