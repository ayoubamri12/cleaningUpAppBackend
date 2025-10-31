<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Models\Price;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;

class PriceController extends Controller
{
    public function index()
    {
        return response()->json(Price::all(), 200);
    }

    // 🔹 Store new tarif
    public function store(Request $request)
    {
        $validated = $request->validate([
            'article_name' => 'required|string|max:255',           
            'unit_type' => 'nullable|string|max:255',
            'price' => 'required|numeric|min:0',
            'description' => 'nullable|string',
        ]);

        $tarif = Price::create($validated);

        return response()->json($tarif, 201);
    }

    // 🔹 Update existing tarif
    public function update(Request $request, $id)
    {
        $tarif = Price::find($id);

        if (!$tarif) {
            return response()->json(['message' => 'Tarif not found'], 404);
        }

        $validated = $request->validate([
            'article_name' => 'sometimes|required|string|max:255',
            'unit_type' => 'nullable|string|max:255',
            'price' => 'sometimes|required|numeric|min:0',
            'description' => 'nullable|string',
            'image_url' => 'nullable|string',
        ]);

        $tarif->update($validated);

        return response()->json($tarif, 200);
    }

    // 🔹 Delete tarif
    public function destroy($id)
    {
        $tarif = Price::find($id);

        if (!$tarif) {
            return response()->json(['message' => 'Tarif not found'], 404);
        }

        $tarif->delete();

        return response()->json(['message' => 'Tarif deleted successfully'], 200);
    }
}
