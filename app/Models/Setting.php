<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\Cache;

class Setting extends Model
{
    protected $fillable = [
        'key',
        'value',
    ];

    public static function get(string $key, mixed $default = null): mixed
    {
        return Cache::rememberForever(
            "settings.{$key}",
            fn () => static::where('key', $key)->value('value') ?? $default
        );
    }

    public static function set(string $key, mixed $value): void
    {
        static::updateOrCreate(['key' => $key], ['value' => $value]);

        Cache::forget("settings.{$key}");
    }

    public static function getBool(string $key, bool $default = false): bool
    {
        $value = static::get($key, $default ? '1' : '0');

        return filter_var($value, FILTER_VALIDATE_BOOLEAN);
    }

    /**
     * Vesszővel elválasztott email-lista beállítás feldolgozott tömbként.
     *
     * @return array<int, string>
     */
    public static function getEmailList(string $key): array
    {
        return collect(explode(',', (string) static::get($key, '')))
            ->map(fn (string $email) => trim($email))
            ->filter()
            ->values()
            ->all();
    }
}
