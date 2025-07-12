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
        Schema::create('reviews', function (Blueprint $table) {
            $table->id();
            $table->foreignId('product_id')->constrained()->onDelete('cascade');
            $table->string('name');
            $table->string('email');
            $table->string('location')->nullable();
            $table->integer('rating'); // 1-5 stars
            $table->string('title');
            $table->text('comment');
            $table->json('helpful_votes')->nullable(); // Track helpful votes
            $table->boolean('is_verified_buyer')->default(false);
            $table->boolean('is_approved')->default(false);
            $table->string('order_reference')->nullable(); // For verified purchases
            $table->timestamp('reviewed_at')->nullable();
            $table->timestamps();
            
            $table->index(['product_id', 'is_approved']);
            $table->index(['rating', 'is_approved']);
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('reviews');
    }
};
