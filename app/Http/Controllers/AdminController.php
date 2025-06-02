<?php

namespace App\Http\Controllers;

use App\Models\Booking; // Make sure this model exists and is imported
use App\Models\Bungalow; // Make sure this model exists and is imported
use App\Models\User;     // Make sure this model exists and is imported
use Illuminate\Http\Request;

class AdminController extends Controller
{
    public function dashboard()
    {
        // Fetch statistics
        $totalBookings = Booking::count();
        $totalUsers = User::count();
        // Assuming your Bungalow model has an 'is_active' column.
        // If not, adjust this line, e.g., Bungalow::count() or a different status column.
        $activeBungalows = Bungalow::count(); // This will count ALL bungalows

        // Fetch latest bookings for the list at the bottom of the dashboard
        $bookings = Booking::with(['user', 'bungalow'])
                           ->latest() // Order by latest bookings
                           ->limit(10) // Limit to the last 10 bookings, for example
                           ->get();

        // Pass all fetched data to the dashboard view
        return view('admin.dashboard', compact('totalBookings', 'activeBungalows', 'totalUsers', 'bookings'));
    }

    // You will need to implement other methods like bookingIndex, userIndex, etc.
    // if you decide to add those routes later.
    // For now, based on your current web.php, only 'dashboard' is directly used.
}
