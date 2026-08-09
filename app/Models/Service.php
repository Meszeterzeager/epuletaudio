<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Service extends Model
{
    protected $fillable = [
        'slug',
        'title',
        'short_description',
        'description',
        'icon',
        'hero_image',
        'order',
        'meta_title',
        'meta_description',
        'og_image',
    ];

    public function getRouteKeyName(): string
    {
        return 'slug';
    }
}
