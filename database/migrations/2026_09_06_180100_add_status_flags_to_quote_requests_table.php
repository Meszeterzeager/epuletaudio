<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::table('quote_requests', function (Blueprint $table) {
            $table->boolean('is_processing')->default(false)->after('status');
            $table->boolean('needs_clarification')->default(false)->after('is_processing');
        });
    }

    public function down(): void
    {
        Schema::table('quote_requests', function (Blueprint $table) {
            $table->dropColumn(['is_processing', 'needs_clarification']);
        });
    }
};
