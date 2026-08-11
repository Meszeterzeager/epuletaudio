<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class BillableService extends Model
{
    protected $fillable = [
        'name',
        'description',
        'default_price',
        'unit',
        'is_active',
    ];

    protected function casts(): array
    {
        return [
            'default_price' => 'decimal:2',
            'is_active' => 'boolean',
        ];
    }
}
