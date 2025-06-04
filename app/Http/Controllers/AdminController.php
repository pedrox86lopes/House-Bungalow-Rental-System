<?php

namespace App\Http\Controllers;

use App\Models\Booking;
use App\Models\Bungalow;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;

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
            'bedrooms' => 'required|integer|min:0',
            'beds' => 'required|integer|min:0',
            'bathrooms' => 'required|numeric|min:0',
            'accommodates' => 'required|integer|min:1',
            'image' => 'nullable|image|mimes:jpeg,png,jpg,gif|max:2048',
        ]);

        $imagePath = null;
        if ($request->hasFile('image')) {
            $imagePath = $request->file('image')->store('bungalows', 'public');
        }

        Bungalow::create([
            'name' => $request->name,
            'description' => $request->description,
            'price_per_night' => $request->price_per_night,
            'bedrooms' => $request->bedrooms,
            'beds' => $request->beds,
            'bathrooms' => $request->bathrooms,
            'accommodates' => $request->accommodates,
            'image_url' => $imagePath,
        ]);

        return redirect()->route('admin.bungalows.index')->with('success', 'Bungalow adicionado com sucesso!');
    }

    /**
     * Show the form for editing the specified bungalow.
     * @param  int  $id
     * @return \Illuminate\View\View
     */
    public function editBungalow($id)
    {
        $bungalow = Bungalow::findOrFail($id); // Find the bungalow or throw 404
        return view('admin.bungalows.edit', compact('bungalow'));
    }

    /**
     * Update the specified bungalow in storage.
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\RedirectResponse
     */
    public function updateBungalow(Request $request, $id)
    {
        $bungalow = Bungalow::findOrFail($id); // Find the bungalow to update

        $request->validate([
            'name' => 'required|string|max:255',
            'description' => 'required|string',
            'price_per_night' => 'required|numeric|min:0',
            'bedrooms' => 'required|integer|min:0',
            'beds' => 'required|integer|min:0',
            'bathrooms' => 'required|numeric|min:0',
            'accommodates' => 'required|integer|min:1',
            'image' => 'nullable|image|mimes:jpeg,png,jpg,gif|max:2048', // Image is nullable for updates
        ]);

        // Handle image update
        if ($request->hasFile('image')) {
            // Delete old image if it exists
            if ($bungalow->image_url && Storage::disk('public')->exists($bungalow->image_url)) {
                Storage::disk('public')->delete($bungalow->image_url);
            }
            // Store new image
            $imagePath = $request->file('image')->store('bungalows', 'public');
            $bungalow->image_url = $imagePath;
        }

        // Update other bungalow details
        $bungalow->name = $request->name;
        $bungalow->description = $request->description;
        $bungalow->price_per_night = $request->price_per_night;
        $bungalow->bedrooms = $request->bedrooms;
        $bungalow->beds = $request->beds;
        $bungalow->bathrooms = $request->bathrooms;
        $bungalow->accommodates = $request->accommodates;

        $bungalow->save(); // Save the updated bungalow

        return redirect()->route('admin.bungalows.index')->with('success', 'Bungalow atualizado com sucesso!');
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
}
