<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Models\Inclusion;
use Illuminate\Http\Request;

class InclusionController extends Controller
{
    public function index()
    {
        return response()->json(Inclusion::all(), 200);
    }

    // 🔹 Store new tarif
    public function store(Request $request)
    {
        $validated = $request->validate([
            'label' => 'string',
        ]);

        $tarif = Inclusion::create($validated);

        return response()->json(Inclusion::all(), 200);
    }

    // 🔹 Update existing tarif
    public function update(Request $request, $id)
    {
        $inclusion = Inclusion::find($id);

        if (!$inclusion) {
            return response()->json(['message' => 'Inclusion not found'], 404);
        }

        $validated = $request->validate([
            'label' => 'string',
        ]);

        $inclusion->update($validated);

        return response()->json(Inclusion::all(), 200);
    }

    // 🔹 Delete tarif
    public function destroy($id)
    {
        $inclusion = Inclusion::find($id);

        if (!$inclusion) {
            return response()->json(['message' => 'inclusion not found'], 404);
        }

        $inclusion->delete();

        return response()->json(Inclusion::all(), 200);
    }
}
