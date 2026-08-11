<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('email_messages', function (Blueprint $table) {
            $table->id();
            $table->foreignId('folder_id')->constrained('email_folders')->cascadeOnDelete();
            $table->string('thread_id')->nullable();
            $table->string('direction'); // inbound | outbound
            $table->string('status')->default('unread'); // unread | read
            $table->string('resend_message_id')->nullable();
            $table->string('message_id_header')->nullable();
            $table->string('in_reply_to')->nullable();
            $table->string('from_name')->nullable();
            $table->string('from_email');
            $table->json('to');
            $table->json('cc')->nullable();
            $table->json('bcc')->nullable();
            $table->string('subject')->nullable();
            $table->longText('body_html')->nullable();
            $table->longText('body_text')->nullable();
            $table->boolean('is_draft')->default(false);
            $table->timestamp('sent_at')->nullable();
            $table->timestamp('received_at')->nullable();
            $table->timestamps();

            $table->index('thread_id');
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('email_messages');
    }
};
