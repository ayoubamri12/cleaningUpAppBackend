<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\HasMany;

class Service extends Model
{
    use HasFactory;

    protected $fillable = [
        'title',
        'description',
        'price',
        'old_price',
        'duration',
        'active',
        'includes',
    ];
    protected $casts = [
        'active' => 'boolean',
        'price' => 'decimal:2',
        'includes' => 'array', // Caste le champ 'includes' en tableau pour gérer le JSON
    ];
    /**
     * A Service can have many Offers (one-to-many relationship).
     */
    public function offers(): HasMany
    {
        return $this->hasMany(Offer::class);
    }
    public function galleries()
    {
        return $this->hasMany(Gallery::class);
    }
    /**
     * A Service can be associated with many Media items (one-to-many relationship).
     */
    
}
