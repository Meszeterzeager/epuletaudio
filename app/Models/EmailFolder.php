<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\HasMany;

class EmailFolder extends Model
{
    protected $fillable = [
        'key',
        'name',
        'type',
        'order',
    ];

    public function messages(): HasMany
    {
        return $this->hasMany(EmailMessage::class, 'folder_id');
    }

    public function isSystem(): bool
    {
        return $this->type === 'system';
    }

    public static function inbox(): self
    {
        return static::where('key', 'inbox')->firstOrFail();
    }

    public static function sent(): self
    {
        return static::where('key', 'sent')->firstOrFail();
    }

    public static function drafts(): self
    {
        return static::where('key', 'drafts')->firstOrFail();
    }

    public static function trash(): self
    {
        return static::where('key', 'trash')->firstOrFail();
    }
}
