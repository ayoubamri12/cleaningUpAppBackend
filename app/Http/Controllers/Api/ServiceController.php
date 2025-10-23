<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Models\Service;
use Illuminate\Http\Request;
use Illuminate\Validation\Rule;
use Illuminate\Support\Str;

class ServiceController extends Controller
{
    /**
     * Display a listing of all services (for admin access).
     */
    public function index()
    {
        // Sort by custom sort_order
        return response()->json(Service::all(),200);
    }

    /**
     * Store a newly created service.
     */
    public function store(Request $request)
    {
        // $validated = $request->validate([
        //     'title' => 'required|string|max:255|unique:services,name',
        //     'description' => 'nullable|string',
        //     'price' => 'required|numeric|min:0',
        //     // Le champ includes est envoyé comme un tableau par React et casté automatiquement par le modèle
        //     'includes' => 'nullable|array', 
        //     'active' => 'required|boolean',
        // ]);
        
        
        $service = Service::create($request->input());
        return response()->json($service, 201);
    }

    /**
     * Display the specified service.
     */
    public function show(Service $service)
    {
        // Retourne le service seul, l'index est suffisant pour le CRUD
        return $service; 
    }

    /**
     * Update the specified service.
     */
    public function update(Request $request, Service $service)
    {
        // $validated = $request->validate([
        //     // Slug est généré à partir du nom, mais le nom doit être unique (excluant le service actuel)
        //     'name' => ['required', 'string', 'max:255', Rule::unique('services')->ignore($service)],
        //     'description' => 'nullable|string',
        //     'base_price' => 'required|numeric|min:0',
        //     // Le champ includes est envoyé comme un tableau par React
        //     'includes' => 'nullable|array', 
        //     'is_active' => 'required|boolean',
        //     'sort_order' => 'integer|min:0',
        // ]);

        // $validated['slug'] = Str::slug($validated['name']);
        $service->update($request->input());

        return response()->json($service);
    }

    /**
     * Remove the specified service.
     */
    public function destroy(Service $service)
    {
        $service->delete();
        // Laravel gère automatiquement la suppression des offres liées (cascade).
        return response()->json($service, 204);
    }
}
