<?php

namespace App\Http\Controllers;

use App\Models\Property;
use Illuminate\Http\Request;

class PropertyController extends Controller
{
    // List all properties with owner, category, and images
    public function index()
    {
        $properties = Property::with(['user', 'category', 'images'])->get();
        return response()->json($properties);
    }

    // Store a new property
    public function store(Request $request)
    {
        $request->validate([
            'user_id' => 'required|exists:users,id',
            'title' => 'required|string|max:255',
            'description' => 'nullable|string',
            'price' => 'required|numeric',
            'type' => 'required|in:rent,mortgage',
            'address' => 'required|string|max:255',
            'city' => 'required|string|max:255',
            'latitude' => 'nullable|numeric',
            'longitude' => 'nullable|numeric',
            'category_id' => 'required|exists:categories,id',
        ]);

        $property = Property::create($request->all());
        return response()->json($property, 201);
    }

    // Show a single property with owner, category, and images
    public function show($id)
    {
        $property = Property::with(['user', 'category', 'images'])->findOrFail($id);
        return response()->json($property);
    }

    // Update a property
    public function update(Request $request, $id)
    {
        $property = Property::findOrFail($id);

        $request->validate([
            'title' => 'sometimes|string|max:255',
            'description' => 'nullable|string',
            'price' => 'sometimes|numeric',
            'type' => 'sometimes|in:rent,mortgage',
            'address' => 'sometimes|string|max:255',
            'city' => 'sometimes|string|max:255',
            'latitude' => 'nullable|numeric',
            'longitude' => 'nullable|numeric',
            'category_id' => 'sometimes|exists:categories,id',
        ]);

        $property->update($request->all());
        return response()->json($property);
    }

    // Delete a property
    public function destroy($id)
    {
        $property = Property::findOrFail($id);
        $property->delete();
        return response()->json(['message' => 'Property deleted successfully']);
    }
}
