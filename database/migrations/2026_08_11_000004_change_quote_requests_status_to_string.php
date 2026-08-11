<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    /**
     * A `status` eredetileg enum (SQLite-on CHECK-constraintes) oszlop volt —
     * mivel doctrine/dbal nincs telepítve, ->change() nem elérhető, ezért
     * drop + újra-létrehozás egy sima string oszlopként (driver-független).
     * Az érvényes értékeket az app-szint (Filament Select + model) validálja.
     */
    public function up(): void
    {
        Schema::table('quote_requests', function (Blueprint $table) {
            $table->dropColumn('status');
        });

        Schema::table('quote_requests', function (Blueprint $table) {
            $table->string('status')->default('new')->after('gdpr_consent');
        });
    }

    public function down(): void
    {
        Schema::table('quote_requests', function (Blueprint $table) {
            $table->dropColumn('status');
        });

        Schema::table('quote_requests', function (Blueprint $table) {
            $table->enum('status', ['new', 'contacted', 'quoted', 'closed'])->default('new')->after('gdpr_consent');
        });
    }
};
