<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\HasMany;

class PurchaseOrder extends Model
{
    protected $fillable = [
        'quote_request_id',
        'supplier_id',
        'status',
        'sent_at',
    ];

    protected function casts(): array
    {
        return [
            'sent_at' => 'datetime',
        ];
    }

    public function quoteRequest(): BelongsTo
    {
        return $this->belongsTo(QuoteRequest::class);
    }

    public function supplier(): BelongsTo
    {
        return $this->belongsTo(Supplier::class);
    }

    public function items(): HasMany
    {
        return $this->hasMany(PurchaseOrderItem::class);
    }

    public function totalAmount(): float
    {
        return (float) $this->items->sum(fn (PurchaseOrderItem $item) => $item->quantity * (float) $item->unit_price);
    }

    public function poNumber(): string
    {
        return sprintf('PO-%s-%03d', $this->created_at?->format('Ymd') ?? now()->format('Ymd'), $this->id);
    }
}
