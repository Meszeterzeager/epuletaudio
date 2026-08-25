<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\HasMany;

class SupplierProduct extends Model
{
    protected $fillable = [
        'supplier_id',
        'name',
        'sku',
        'category',
        'description',
        'image',
        'purchase_price',
        'selling_price',
        'currency',
        'unit',
        'is_active',
        'is_public_showcase',
        'last_price_updated_at',
    ];

    protected function casts(): array
    {
        return [
            'purchase_price' => 'decimal:2',
            'selling_price' => 'decimal:2',
            'is_active' => 'boolean',
            'is_public_showcase' => 'boolean',
            'last_price_updated_at' => 'datetime',
        ];
    }

    public function supplier(): BelongsTo
    {
        return $this->belongsTo(Supplier::class);
    }

    public function files(): HasMany
    {
        return $this->hasMany(SupplierProductFile::class);
    }

    public function images(): HasMany
    {
        return $this->hasMany(SupplierProductImage::class)->orderBy('order');
    }
}
