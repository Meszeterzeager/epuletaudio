<?php

namespace App\Models;

use App\Mail\OrderConfirmedMail;
use App\Services\PurchaseOrderGenerator;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\HasMany;
use Illuminate\Support\Facades\Mail;

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
        'sound_system_type',
        'conference_room_type',
        'conference_moderator_count',
        'has_room_sound_system',
        'conference_president_mic_count',
        'conference_delegate_mic_count',
        'conference_recording_type',
        'conference_room_sound_system_type',
        'conference_room_sound_system_other',
        'mobile_headcount',
        'mobile_area_size',
        'mobile_speaker_type',
        'amplifier_type',
        'amplifier_type_other',
        'tour_type',
        'group_size',
        'tour_guide_count',
        'needs_transport_case',
        'needs_fast_charger',
        'leads_small_groups',
        'delivery_method',
        'room_count',
        'source_count',
        'area_sqm',
        'width_m',
        'length_m',
        'ceiling_height_m',
        'has_suspended_ceiling',
        'suspended_ceiling_type',
        'speaker_preference',
        'project_stage',
        'existing_system',
        'existing_system_notes',
        'source_equipment',
        'source_equipment_other',
        'priority',
        'budget_huf',
        'wants_installation',
        'wants_site_survey',
        'site_survey_address',
        'site_survey_notes',
        'needed_by_date',
        'video_url',
        'message',
        'preferred_timeframe',
        'gdpr_consent',
        'status',
        'internal_notes',
        'is_processing',
        'needs_clarification',
    ];

    protected function casts(): array
    {
        return [
            'requested_systems' => 'array',
            'speaker_preference' => 'array',
            'source_equipment' => 'array',
            'mobile_speaker_type' => 'array',
            'existing_system' => 'boolean',
            'has_suspended_ceiling' => 'boolean',
            'has_room_sound_system' => 'boolean',
            'needs_transport_case' => 'boolean',
            'needs_fast_charger' => 'boolean',
            'leads_small_groups' => 'boolean',
            'wants_installation' => 'boolean',
            'wants_site_survey' => 'boolean',
            'gdpr_consent' => 'boolean',
            'is_processing' => 'boolean',
            'needs_clarification' => 'boolean',
            'area_sqm' => 'decimal:2',
            'width_m' => 'decimal:2',
            'length_m' => 'decimal:2',
            'ceiling_height_m' => 'decimal:2',
            'needed_by_date' => 'date',
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

                Mail::to($quoteRequest->email)->queue(new OrderConfirmedMail($quoteRequest));
            }
        });
    }
}
