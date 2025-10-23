<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class Offer extends Model
{
    use HasFactory;

    /**
     * Les attributs qui peuvent être massivement assignés (mass assignable).
     */
    protected $fillable = [
        'service_id',
        'title',
        'description',
        'discount_type',
        'discount_value',
        'is_scheduled_day',
        'starts_at',
        'ends_at',
    ];

    /**
     * Les attributs qui doivent être castés en types natifs.
     */
    protected $casts = [
        'is_scheduled_day' => 'boolean',
        'starts_at' => 'datetime',
        'ends_at' => 'datetime',
        'discount_value' => 'float',
    ];

    /**
     * Relation: Une offre appartient à un service.
     */
    public function service(): BelongsTo
    {
        // Assurez-vous que le modèle Service existe
        return $this->belongsTo(Service::class);
    }

    // --- LOGIQUE SPÉCIALE D'OFFRE (Portée et Accesseurs) ---

    /**
     * Scope local pour récupérer uniquement les offres actuellement actives.
     * Utilisation : Offer::active()->get()
     */
    public function scopeActive($query)
    {
        return $query->where('starts_at', '<=', now())
                     ->where('ends_at', '>=', now());
    }

    /**
     * Accesseur pour déterminer si l'offre est active actuellement.
     */
    public function getIsActiveAttribute(): bool
    {
        return $this->starts_at <= now() && $this->ends_at >= now();
    }
}
