<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::table('quote_requests', function (Blueprint $table) {
            $table->string('amplifier_type_other')->nullable()->after('amplifier_type');
            $table->string('site_survey_address')->nullable()->after('wants_site_survey');
            $table->text('site_survey_notes')->nullable()->after('site_survey_address');
        });
    }

    public function down(): void
    {
        Schema::table('quote_requests', function (Blueprint $table) {
            $table->dropColumn(['amplifier_type_other', 'site_survey_address', 'site_survey_notes']);
        });
    }
};
