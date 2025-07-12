<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    /**
     * Run the migrations.
     */
    public function up(): void
    {
        Schema::table('reviews', function (Blueprint $table) {
            // Add likes count column
            $table->integer('likes_count')->default(0)->after('helpful_votes');
            
            // Add user IP tracking for anonymous likes
            $table->json('liked_by_ips')->nullable()->after('likes_count');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('reviews', function (Blueprint $table) {
            $table->dropColumn(['likes_count', 'liked_by_ips']);
        });
    }
};
