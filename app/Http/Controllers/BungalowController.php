<?php

namespace App\Http\Controllers;

use App\Models\Bungalow;
use App\Models\Booking; // <--- ADD THIS LINE
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;

class BungalowController extends Controller
{
    /**
     * Display a listing of the bungalow.
     */
    public function index(Request $request)
    {
        $query = Bungalow::query();

        // Handle search filter
        if ($request->filled('search')) { // Use filled for better check
            $searchTerm = '%' . $request->input('search') . '%';
            $query->where('name', 'like', $searchTerm)
                  ->orWhere('description', 'like', $searchTerm);
        }

        // Handle date range filter
        $startDate = $request->input('start_date');
        $endDate = $request->input('end_date');

        if ($startDate && $endDate) {
            // Eager load bookings relationship with a constraint to filter for the selected date range
            // This allows us to check for overlaps when iterating through bungalows in the view
            $query->with(['bookings' => function ($q) use ($startDate, $endDate) {
                $q->where('start_date', '<', $endDate) // Booking starts before requested end
                  ->where('end_date', '>', $startDate)   // Booking ends after requested start
                  ->whereIn('status', ['paid', 'pending']); // Only consider paid or pending bookings as unavailable
            }]);
        }

        // Changed from get() to paginate() for better performance with many bungalows
        $bungalows = $query->orderBy('name')->paginate(10); // Adjust pagination limit as needed

        // Pass the dates back to the view so they can be re-populated in the filter form
        return view('bungalows.index', [
            'bungalows' => $bungalows,
            'startDate' => $startDate,
            'endDate' => $endDate,
        ]);
    }

    /**
     * Show the form for creating a new bungalow.
     */
    public function create()
    {
        return view('bungalows.create');
    }

    /**
     * Store a newly created bungalow in storage.
     */
    public function store(Request $request)
    {
        $request->validate([
            'name' => 'required|string|max:255',
            'description' => 'required|string',
            'price_per_night' => 'required|numeric|min:0',
            'bedrooms' => 'nullable|integer|min:0',
            'beds' => 'nullable|integer|min:0',
            'bathrooms' => 'nullable|numeric|min:0',
            'accommodates' => 'nullable|integer|min:1',
            'image' => 'nullable|image|mimes:jpeg,png,jpg,gif|max:2048',
        ]);

        $bungalow = new Bungalow();
        $bungalow->name = $request->name;
        $bungalow->description = $request->description;
        $bungalow->price_per_night = $request->price_per_night;

        $bungalow->bedrooms = $request->bedrooms;
        $bungalow->beds = $request->beds;
        $bungalow->bathrooms = $request->bathrooms;
        $bungalow->accommodates = $request->accommodates;

        if ($request->hasFile('image')) {
            $imagePath = $request->file('image')->store('bungalows', 'public');
            $bungalow->image_url = $imagePath; // Changed from 'image' to 'image_url' to match your blade
        }

        $bungalow->save();

        return redirect()->route('admin.bungalows.index')->with('success', 'Bungalow adicionado com sucesso!');
    }

    /**
     * Display the specified bungalow.
     */
    public function show($id)
    {
        $bungalow = Bungalow::findOrFail($id);
        // You might want to pass the date parameters to the show view as well
        // if you allow direct booking from there.
        // For simplicity, we'll assume the booking form itself handles passing them from index to create.
        return view('bungalows.show', compact('bungalow'));
    }

    /**
     * Remove the specified bungalow from storage.
     */
    public function destroy($id)
    {
        $bungalow = Bungalow::findOrFail($id);

        if ($bungalow->image_url) { // Changed from 'image' to 'image_url'
            Storage::disk('public')->delete($bungalow->image_url);
        }

        $bungalow->delete();

        return redirect()->route('admin.bungalows.index')->with('success', 'Bungalow eliminado com sucesso!');
    }

    /**
     * Get unavailable dates for a specific bungalow. (For AJAX use with date pickers)
     * @param \App\Models\Bungalow $bungalow
     * @return \Illuminate\Http\JsonResponse
     */
    public function getUnavailableDates(Bungalow $bungalow)
    {
        $bookedDates = Booking::where('bungalow_id', $bungalow->id)
                              ->whereIn('status', ['paid', 'pending'])
                              ->select('start_date', 'end_date')
                              ->get();

        $unavailableRanges = [];
        foreach ($bookedDates as $booking) {
            $unavailableRanges[] = [
                'from' => $booking->start_date,
                'to' => $booking->end_date,
            ];
        }

        return response()->json($unavailableRanges);
    }
}
