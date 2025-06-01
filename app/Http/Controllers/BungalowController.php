<?php

namespace App\Http\Controllers;

use App\Models\Bungalow;
use Illuminate\Http\Request;

class BungalowController extends Controller
{
    public function index(Request $request)
    {
        // Start with all bungalows
        $query = Bungalow::query();

        // Check if a search term is present in the request
        if ($search = $request->query('search')) {
            // Apply the search filter
            // We use 'like' for partial matches, and 'orWhere' to search across multiple columns
            $query->where('name', 'like', '%' . $search . '%')
                  ->orWhere('description', 'like', '%' . $search . '%');
        }

        // Get the filtered (or unfiltered) bungalows
        $bungalows = $query->orderBy('name')->get(); // You can adjust the ordering

        return view('bungalows.index', compact('bungalows'));
    }

    public function show($id)
    {
        $bungalow = Bungalow::findOrFail($id);
        return view('bungalows.show', compact('bungalow'));
    }

    // ... other methods (create, store, edit, update, destroy)
}
