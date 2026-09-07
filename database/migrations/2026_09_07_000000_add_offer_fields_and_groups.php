<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::table('quote_requests', function (Blueprint $table): void {
            $table->string('offer_number')->nullable()->unique()->after('status');
            $table->text('system_description')->nullable()->after('internal_notes');
            $table->string('delivery_weeks')->default('2-3 hét')->after('system_description');
        });

        Schema::table('quote_request_items', function (Blueprint $table): void {
            $table->string('group_name')->nullable()->after('description');
            $table->string('unit')->default('db')->after('quantity');
        });
    }

    public function down(): void
    {
        Schema::table('quote_request_items', function (Blueprint $table): void {
            $table->dropColumn(['group_name', 'unit']);
        });
        Schema::table('quote_requests', function (Blueprint $table): void {
            $table->dropUnique(['offer_number']);
            $table->dropColumn(['offer_number', 'system_description', 'delivery_weeks']);
        });
    }
};
