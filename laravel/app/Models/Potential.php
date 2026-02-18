<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Potential extends Model
{
    use HasFactory;

    protected $fillable = [
        'user_id',
        'village_id',
        'category_id',
        'title',
        'slug',
        'description',
        'whatsapp_number',
        'location_address',
        'price_range',
        'latitude',
        'longitude',
        'source',
        'verification_status',
        'images',
        'attributes',
    ];

    protected $casts = [
        'images' => 'array',
        'attributes' => 'array',
    ];

    public function village()
    {
        return $this->belongsTo(Village::class);
    }

    public function owner()
    {
        return $this->belongsTo(User::class, 'user_id');
    }
}
