<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('email_label_email_message', function (Blueprint $table) {
            $table->id();
            $table->foreignId('email_label_id')->constrained()->cascadeOnDelete();
            $table->foreignId('email_message_id')->constrained()->cascadeOnDelete();
            $table->timestamps();

            $table->unique(['email_label_id', 'email_message_id'], 'label_message_unique');
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('email_label_email_message');
    }
};
