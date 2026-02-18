<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Village extends Model
{
    use HasFactory;

    protected $fillable = [
        'district_name',
        'village_name',
        'slug',
        'website_url',
        'api_endpoint',
        'platform',
        'has_active_website',
        'population',
        'last_scraped_at',
        'source_meta',
    ];

    protected $casts = [
        'has_active_website' => 'boolean',
        'last_scraped_at' => 'datetime',
        'source_meta' => 'array',
    ];

    public function potentials()
    {
        return $this->hasMany(Potential::class);
    }
}
