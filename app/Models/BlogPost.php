<?php

namespace App\Models;

use App\Services\HtmlSanitizer;
use Illuminate\Database\Eloquent\Casts\Attribute;
use Illuminate\Database\Eloquent\Model;

class BlogPost extends Model
{
    protected $fillable = [
        'slug',
        'title',
        'excerpt',
        'body',
        'cover_image',
        'published_at',
        'meta_title',
        'meta_description',
        'og_image',
    ];

    protected function casts(): array
    {
        return [
            'published_at' => 'datetime',
        ];
    }

    public function getRouteKeyName(): string
    {
        return 'slug';
    }

    protected function body(): Attribute
    {
        return Attribute::make(
            get: fn (?string $value): ?string => HtmlSanitizer::sanitizeRichContent($value),
            set: fn (?string $value): ?string => HtmlSanitizer::sanitizeRichContent($value),
        );
    }
}
