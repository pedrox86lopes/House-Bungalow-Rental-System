<?php

namespace App\Http\Controllers;

use App\Models\Booking;
use App\Models\Bungalow; // Make sure Bungalow model is imported
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage; // For file operations

class AdminController extends Controller
{
    public function dashboard()
    {
        $totalBookings = Booking::count();
        $totalUsers = User::count();
        $activeBungalows = Bungalow::count();

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

        return view('admin.dashboard', compact(
            'totalBookings',
            'activeBungalows',
            'totalUsers',
            'paidBookings',
            'pendingBookings',
            'cancelledBookings'
        ));
    }

    /**
     * Display a list of bungalows for admin to manage.
     * @return \Illuminate\View\View
     */
    public function bungalowsIndex()
    {
        $bungalows = Bungalow::orderBy('created_at', 'desc')->get();
        return view('admin.bungalows.index', compact('bungalows'));
    }

    /**
     * Show the form for creating a new bungalow.
     * @return \Illuminate\View\View
     */
    public function createBungalow()
    {
        return view('admin.bungalows.create');
    }

    /**
     * Store a newly created bungalow in storage.
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\RedirectResponse
     */
    public function storeBungalow(Request $request)
    {
        $request->validate([
            'name' => 'required|string|max:255',
            'description' => 'required|string',
            'price_per_night' => 'required|numeric|min:0',
            // --- ADD NEW FIELD VALIDATION RULES HERE ---
            'bedrooms' => 'required|integer|min:0',
            'beds' => 'required|integer|min:0',
            'bathrooms' => 'required|numeric|min:0', // Use numeric for bathrooms if step="0.5"
            'accommodates' => 'required|integer|min:1',
            // --- END NEW FIELD VALIDATION RULES ---
            'image' => 'nullable|image|mimes:jpeg,png,jpg,gif|max:2048', // Max 2MB
        ]);

        $imagePath = null;
        if ($request->hasFile('image')) {
            // Stores in storage/app/public/bungalow_images and returns path like 'bungalow_images/filename.jpg'
            $imagePath = $request->file('image')->store('bungalow_images', 'public');
        }

        // --- ADD NEW FIELDS TO THE CREATE ARRAY HERE ---
        Bungalow::create([
            'name' => $request->name,
            'description' => $request->description,
            'price_per_night' => $request->price_per_night,
            'bedrooms' => $request->bedrooms,       // Add this line
            'beds' => $request->beds,               // Add this line
            'bathrooms' => $request->bathrooms,     // Add this line
            'accommodates' => $request->accommodates, // Add this line
            'image_url' => $imagePath, // This matches your model's $fillable 'image_url'
        ]);
        // --- END NEW FIELDS TO THE CREATE ARRAY ---

        return redirect()->route('admin.bungalows.index')->with('success', 'Bungalow adicionado com sucesso!');
    }

    /**
     * Remove the specified bungalow from storage.
     * @param  int  $id
     * @return \Illuminate\Http\RedirectResponse
     */
    public function destroyBungalow($id)
    {
        $bungalow = Bungalow::findOrFail($id);

        // Delete associated image if it exists
        if ($bungalow->image_url && Storage::disk('public')->exists($bungalow->image_url)) {
            Storage::disk('public')->delete($bungalow->image_url);
        }

        $bungalow->delete();

        return redirect()->route('admin.bungalows.index')->with('success', 'Bungalow eliminado com sucesso!');
    }

    // You can add editBungalow and updateBungalow methods here if you want to implement editing.
}
