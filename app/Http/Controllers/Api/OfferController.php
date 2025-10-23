<?php

namespace App\Http\Controllers\Api;


use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\Offer;
use App\Models\Service; // Assurez-vous que ce modèle existe
use Illuminate\Validation\Rule;
use Symfony\Component\HttpFoundation\Response;

class OfferController extends Controller
{
    /**
     * Retourne la liste des offres (GET /admin/offers)
     */
    public function index()
    {
        // Charge toutes les offres avec le service associé pour l'affichage
        // Utilise l'accessoire 'is_active' du modèle pour déterminer l'état actuel de l'offre
        return Offer::with('service')->get();
    }
    public function activeOffers()
    {
        // Charge toutes les offres avec le service associé pour l'affichage
        // Utilise l'accessoire 'is_active' du modèle pour déterminer l'état actuel de l'offre
      return  Offer::active()->get();
    }

    /**
     * Crée une nouvelle offre (POST /admin/offers)
     */
    public function store(Request $request)
    {
        // --- LOGIQUE DE VALIDATION CÔTÉ SERVEUR ---
        $validatedData = $request->validate([
            // Vérifie l'existence dans la base de données
            'service_id' => ['required', 'integer', Rule::exists('services', 'id')],
            'title' => ['required', 'string', 'max:255', 'min:3'],
            'description' => ['nullable', 'string'],

            // Restreint le type de réduction aux valeurs autorisées
            'discount_type' => ['required', 'string', Rule::in(['percentage', 'fixed_amount', 'new_price'])],
            'discount_value' => ['required', 'numeric', 'min:0'],

            // S'assure de la validité des dates
            'starts_at' => ['required', 'date'],
            'ends_at' => ['required', 'date', 'after:starts_at'],

            'is_scheduled_day' => ['required', 'boolean'],
        ]);
        // --- FIN DE LA LOGIQUE DE VALIDATION ---

        // Création de l'offre
        $validatedData['discount_value'] = $validatedData['discount_type'] === 'percentage' ? $validatedData['discount_value'] / 100 : $validatedData['discount_value'];
        $offer = Offer::create(
            $validatedData

        );

        return response()->json($offer, Response::HTTP_CREATED); // Code 201
    }

    /**
     * Met à jour une offre spécifique (PUT/PATCH /admin/offers/{offer})
     */
    public function update(Request $request, Offer $offer)
    {
        // Même validation, appliquée à la mise à jour
        $validatedData = $request->validate([
            'service_id' => ['required', 'integer', Rule::exists('services', 'id')],
            'title' => ['required', 'string', 'max:255', 'min:3'],
            'description' => ['nullable', 'string'],
            'discount_type' => ['required', 'string', Rule::in(['percentage', 'fixed_amount', 'new_price'])],
            'discount_value' => ['required', 'numeric', 'min:0'],
            'starts_at' => ['required', 'date'],
            'ends_at' => ['required', 'date', 'after:starts_at'],
            'is_scheduled_day' => ['required', 'boolean'],
        ]);
        $validatedData['discount_value'] = $validatedData['discount_type'] === 'percentage' ? $validatedData['discount_value'] / 100 : $validatedData['discount_value'];
        // Mise à jour de l'offre
        $offer->update($validatedData);

        return response()->json($offer);
    }

    /**
     * Supprime une offre spécifique (DELETE /admin/offers/{offer})
     */
    public function destroy(Offer $offer)
    {
        $offer->delete();
        return response()->json(null, Response::HTTP_NO_CONTENT); // Code 204
    }

    /**
     * Retourne la liste des services (GET /admin/services)
     * Requis pour populer le menu déroulant 'service_id' dans le front-end.
     */
    public function listServices()
    {
        // Retourne uniquement l'ID et le nom pour le formulaire
        return Service::all(['id', 'name']);
    }
}
