<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::table('quote_requests', function (Blueprint $table) {
            $table->boolean('has_suspended_ceiling')->default(false)->after('ceiling_height_m');
            $table->string('suspended_ceiling_type')->nullable()->after('has_suspended_ceiling');
        });
    }

    public function down(): void
    {
        Schema::table('quote_requests', function (Blueprint $table) {
            $table->dropColumn(['has_suspended_ceiling', 'suspended_ceiling_type']);
        });
    }
};
