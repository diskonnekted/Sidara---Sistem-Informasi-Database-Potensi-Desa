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
        'price_range',
        'latitude',
        'longitude',
        'source',
        'verification_status',
        'images',
    ];

    protected $casts = [
        'images' => 'array',
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

