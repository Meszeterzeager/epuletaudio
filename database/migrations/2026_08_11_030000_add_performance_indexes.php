<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::table('projects', function (Blueprint $table) {
            $table->index(['is_active', 'completed_at']);
        });

        Schema::table('blog_posts', function (Blueprint $table) {
            $table->index('published_at');
        });

        Schema::table('quote_requests', function (Blueprint $table) {
            $table->index('status');
        });
    }

    public function down(): void
    {
        Schema::table('projects', function (Blueprint $table) {
            $table->dropIndex(['is_active', 'completed_at']);
        });

        Schema::table('blog_posts', function (Blueprint $table) {
            $table->dropIndex(['published_at']);
        });

        Schema::table('quote_requests', function (Blueprint $table) {
            $table->dropIndex(['status']);
        });
    }
};
