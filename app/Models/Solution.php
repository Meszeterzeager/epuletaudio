<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\HasMany;

class Solution extends Model
{
    protected $fillable = [
        'slug',
        'industry_name',
        'description',
        'challenges',
        'recommended_package',
        'hero_image',
        'order',
        'meta_title',
        'meta_description',
        'og_image',
    ];

    protected function casts(): array
    {
        return [
            'challenges' => 'array',
            'recommended_package' => 'array',
        ];
    }

    public function getRouteKeyName(): string
    {
        return 'slug';
    }

    public function projects(): HasMany
    {
        return $this->hasMany(Project::class);
    }
}
