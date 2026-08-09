<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::table('quote_requests', function (Blueprint $table) {
            // Tér jellemzői
            $table->string('space_character')->nullable()->after('requested_systems');
            $table->decimal('width_m', 6, 2)->nullable()->after('area_sqm');
            $table->decimal('length_m', 6, 2)->nullable()->after('width_m');
            $table->decimal('ceiling_height_m', 6, 2)->nullable()->after('length_m');

            // Hangfal-preferencia és projekt stádiuma
            $table->json('speaker_preference')->nullable()->after('ceiling_height_m');
            $table->string('project_stage')->nullable()->after('speaker_preference');

            // Forráseszközök
            $table->json('source_equipment')->nullable()->after('existing_system_notes');

            // Prioritások és keret
            $table->string('priority')->nullable()->after('source_equipment');
            $table->string('budget_huf')->nullable()->after('priority');

            // Kivitelezés és helyszíni felmérés igénye
            $table->boolean('wants_installation')->default(false)->after('budget_huf');
            $table->boolean('wants_site_survey')->default(false)->after('wants_installation');
        });
    }

    public function down(): void
    {
        Schema::table('quote_requests', function (Blueprint $table) {
            $table->dropColumn([
                'space_character',
                'width_m',
                'length_m',
                'ceiling_height_m',
                'speaker_preference',
                'project_stage',
                'source_equipment',
                'priority',
                'budget_huf',
                'wants_installation',
                'wants_site_survey',
            ]);
        });
    }
};
