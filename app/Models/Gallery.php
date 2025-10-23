<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Gallery extends Model
{
    use HasFactory;
      protected $fillable = [
        'service_id',
        'before_image',
        'after_image',
        'caption',
    ];

    public function service()
    {
        return $this->belongsTo(Service::class);
    }
}
