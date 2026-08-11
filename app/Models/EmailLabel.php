<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsToMany;

class EmailLabel extends Model
{
    protected $fillable = [
        'name',
        'color',
    ];

    public function messages(): BelongsToMany
    {
        return $this->belongsToMany(EmailMessage::class, 'email_label_email_message');
    }

    /**
     * @return array{bg: string, color: string}
     */
    public function chipStyle(): array
    {
        return match ($this->color) {
            'rose' => ['bg' => '#fff1f4', 'color' => '#790e3d'],
            default => ['bg' => '#e9f8ff', 'color' => '#004961'],
        };
    }
}
