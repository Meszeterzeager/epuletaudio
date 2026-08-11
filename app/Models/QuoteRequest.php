<?php

namespace App\Models;

use App\Services\PurchaseOrderGenerator;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\HasMany;

class QuoteRequest extends Model
{
    protected $fillable = [
        'name',
        'email',
        'phone',
        'company',
        'building_type',
        'requested_systems',
        'space_character',
        'room_count',
        'source_count',
        'area_sqm',
        'width_m',
        'length_m',
        'ceiling_height_m',
        'speaker_preference',
        'project_stage',
        'existing_system',
        'existing_system_notes',
        'source_equipment',
        'priority',
        'budget_huf',
        'wants_installation',
        'wants_site_survey',
        'video_url',
        'message',
        'preferred_timeframe',
        'gdpr_consent',
        'status',
        'internal_notes',
    ];

    protected function casts(): array
    {
        return [
            'requested_systems' => 'array',
            'speaker_preference' => 'array',
            'source_equipment' => 'array',
            'existing_system' => 'boolean',
            'wants_installation' => 'boolean',
            'wants_site_survey' => 'boolean',
            'gdpr_consent' => 'boolean',
            'area_sqm' => 'decimal:2',
            'width_m' => 'decimal:2',
            'length_m' => 'decimal:2',
            'ceiling_height_m' => 'decimal:2',
        ];
    }

    public function files(): HasMany
    {
        return $this->hasMany(QuoteRequestFile::class);
    }

    public function items(): HasMany
    {
        return $this->hasMany(QuoteRequestItem::class)->orderBy('order');
    }

    public function purchaseOrders(): HasMany
    {
        return $this->hasMany(PurchaseOrder::class);
    }

    public const STATUSES = [
        'new' => 'Új',
        'quote_issued' => 'Ajánlat kiadva',
        'ordered' => 'Ajánlat lerendelve',
        'postponed' => 'Ajánlat elhalasztva',
    ];

    protected static function booted(): void
    {
        static::updated(function (QuoteRequest $quoteRequest): void {
            if ($quoteRequest->wasChanged('status') && $quoteRequest->status === 'ordered') {
                app(PurchaseOrderGenerator::class)->generateForQuoteRequest($quoteRequest);
            }
        });
    }
}
