<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::table('quote_requests', function (Blueprint $table) {
            // Épülethangosítás
            $table->string('sound_system_type')->nullable()->after('space_character');

            // Konferenciarendszer
            $table->string('conference_room_type')->nullable()->after('sound_system_type');
            $table->unsignedInteger('conference_moderator_count')->nullable()->after('conference_room_type');
            $table->boolean('has_room_sound_system')->default(false)->after('suspended_ceiling_type');
            $table->unsignedInteger('conference_president_mic_count')->nullable()->after('has_room_sound_system');
            $table->unsignedInteger('conference_delegate_mic_count')->nullable()->after('conference_president_mic_count');
            $table->string('conference_recording_type')->nullable()->after('conference_delegate_mic_count');
            $table->string('conference_room_sound_system_type')->nullable()->after('conference_recording_type');
            $table->string('conference_room_sound_system_other')->nullable()->after('conference_room_sound_system_type');

            // Mobil hangosítás
            $table->unsignedInteger('mobile_headcount')->nullable()->after('conference_room_sound_system_other');
            $table->string('mobile_area_size')->nullable()->after('mobile_headcount');
            $table->json('mobile_speaker_type')->nullable()->after('mobile_area_size');
            $table->string('amplifier_type')->nullable()->after('mobile_speaker_type');

            // Tourguide rendszer
            $table->string('tour_type')->nullable()->after('amplifier_type');
            $table->unsignedInteger('group_size')->nullable()->after('tour_type');
            $table->unsignedInteger('tour_guide_count')->nullable()->after('group_size');
            $table->boolean('needs_transport_case')->default(false)->after('tour_guide_count');
            $table->boolean('needs_fast_charger')->default(false)->after('needs_transport_case');
            $table->boolean('leads_small_groups')->default(false)->after('needs_fast_charger');
            $table->string('delivery_method')->nullable()->after('leads_small_groups');

            // Forráseszközök — "egyéb" szabadszöveges kiegészítés
            $table->string('source_equipment_other')->nullable()->after('source_equipment');

            // Az ajánlat elkészítéséhez szükséges határidő (a prioritások lépés végén)
            $table->date('needed_by_date')->nullable()->after('wants_site_survey');
        });
    }

    public function down(): void
    {
        Schema::table('quote_requests', function (Blueprint $table) {
            $table->dropColumn([
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
                'tour_type',
                'group_size',
                'tour_guide_count',
                'needs_transport_case',
                'needs_fast_charger',
                'leads_small_groups',
                'delivery_method',
                'source_equipment_other',
                'needed_by_date',
            ]);
        });
    }
};
