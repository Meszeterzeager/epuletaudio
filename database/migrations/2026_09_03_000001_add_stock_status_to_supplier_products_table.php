<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::table('supplier_products', function (Blueprint $table) {
            $table->string('stock_status')->nullable()->after('unit');
            $table->timestamp('stock_checked_at')->nullable()->after('stock_status');
            $table->unique(['supplier_id', 'sku']);
        });
    }

    public function down(): void
    {
        Schema::table('supplier_products', function (Blueprint $table) {
            $table->dropUnique(['supplier_id', 'sku']);
            $table->dropColumn(['stock_status', 'stock_checked_at']);
        });
    }
};
