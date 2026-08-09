<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('quote_requests', function (Blueprint $table) {
            $table->id();

            // 1. lépés — kapcsolattartó
            $table->string('name');
            $table->string('email');
            $table->string('phone');
            $table->string('company')->nullable();

            // 2. lépés — projekt típusa
            $table->string('building_type');
            $table->json('requested_systems');

            // 3. lépés — műszaki adatok
            $table->unsignedInteger('room_count')->nullable();
            $table->unsignedInteger('source_count')->nullable();
            $table->decimal('area_sqm', 8, 2)->nullable();
            $table->boolean('existing_system')->default(false);
            $table->text('existing_system_notes')->nullable();

            // 4. lépés — csatolmányok
            $table->string('video_url')->nullable();

            // 5. lépés — egyéb
            $table->text('message')->nullable();
            $table->string('preferred_timeframe')->nullable();
            $table->boolean('gdpr_consent')->default(false);

            // admin kezelés
            $table->enum('status', ['new', 'contacted', 'quoted', 'closed'])->default('new');
            $table->text('internal_notes')->nullable();

            $table->timestamps();
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('quote_requests');
    }
};
