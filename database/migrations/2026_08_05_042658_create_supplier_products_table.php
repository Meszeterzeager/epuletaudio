<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('supplier_products', function (Blueprint $table) {
            $table->id();
            $table->foreignId('supplier_id')->constrained('suppliers')->cascadeOnDelete();
            $table->string('name');
            $table->string('sku')->nullable();
            $table->string('category')->nullable();
            $table->text('description')->nullable();
            $table->string('image')->nullable();
            $table->decimal('purchase_price', 10, 2)->nullable();
            $table->string('currency', 3)->default('HUF');
            $table->string('unit')->nullable();
            $table->boolean('is_active')->default(true);
            $table->boolean('is_public_showcase')->default(false);
            $table->timestamp('last_price_updated_at')->nullable();
            $table->timestamps();
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('supplier_products');
    }
};
