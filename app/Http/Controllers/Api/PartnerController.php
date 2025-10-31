<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Models\Partner;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;

class PartnerController extends Controller
{
    public function index()
    {
        return response()->json(Partner::all());
    }

    // Ajouter un partenaire
    public function store(Request $request)
    {
        $validated = $request->validate([
            'name' => 'required|string|max:255',
            'logo_path' => 'required|image|mimes:png,jpg,jpeg,webp|max:2048',
        ]);

        $path = $request->file('logo_path')->store('partners', 'public');

        $partner = Partner::create([
            'name' => $validated['name'],
            'logo_path' => '/storage/' . $path,
        ]);

        return response()->json(Partner::all(), 201);
    }

    // Supprimer un partenaire
    public function destroy(Partner $partner)
    {
        if (Storage::disk('public')->exists(str_replace('/storage/', '', $partner->logo_path))) {
            Storage::disk('public')->delete(str_replace('/storage/', '', $partner->logo_path));
        }

        $partner->delete();

        return response()->json(Partner::all());
    }
}
