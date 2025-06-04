<?php

namespace App\Http\Controllers;

use App\Models\Bungalow;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage; // Make sure to import Storage

class BungalowController extends Controller
{
    /**
     * Display a listing of the bungalow.
     */
    public function index(Request $request)
    {
        $query = Bungalow::query();

        if ($search = $request->query('search')) {
            $query->where('name', 'like', '%' . $search . '%')
                  ->orWhere('description', 'like', '%' . $search . '%');
        }

        $bungalows = $query->orderBy('name')->get();

        return view('bungalows.index', compact('bungalows'));
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
            // Add validation rules for new fields if you've added them to the form
            'bedrooms' => 'nullable|integer|min:0', // assuming you'll add this to the form
            'beds' => 'nullable|integer|min:0',     // assuming you'll add this to the form
            'bathrooms' => 'nullable|numeric|min:0', // assuming you'll add this to the form
            'accommodates' => 'nullable|integer|min:1', // assuming you'll add this to the form
            'image' => 'nullable|image|mimes:jpeg,png,jpg,gif|max:2048',
        ]);

        $bungalow = new Bungalow();
        $bungalow->name = $request->name;
        $bungalow->description = $request->description;
        $bungalow->price_per_night = $request->price_per_night;

        // Assign new fields if they exist in the request
        $bungalow->bedrooms = $request->bedrooms;
        $bungalow->beds = $request->beds;
        $bungalow->bathrooms = $request->bathrooms;
        $bungalow->accommodates = $request->accommodates;

        if ($request->hasFile('image')) {
            // This is the correct way to store files on the 'public' disk
            // It will save to storage/app/public/bungalows/ and return 'bungalows/filename.jpg'
            $imagePath = $request->file('image')->store('bungalows', 'public');

            // Store the returned path directly in the database. No need for str_replace().
            $bungalow->image = $imagePath;
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
        return view('bungalows.show', compact('bungalow'));
    }

    /**
     * Remove the specified bungalow from storage.
     */
    public function destroy($id)
    {
        $bungalow = Bungalow::findOrFail($id);

        if ($bungalow->image) {
            // Delete the image file from the 'public' disk.
            // The path stored in the database ('bungalows/filename.jpg') is relative to this disk's root.
            Storage::disk('public')->delete($bungalow->image);
        }

        $bungalow->delete();

        return redirect()->route('admin.bungalows.index')->with('success', 'Bungalow eliminado com sucesso!');
    }
}
