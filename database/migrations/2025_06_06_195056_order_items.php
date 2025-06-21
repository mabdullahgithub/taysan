<?php
// Migration: create_orders_table.php
use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;
return new class extends Migration
{
    public function up(): void
    {
        Schema::create('order_items', function (Blueprint $table) {
            $table->id();
            $table->foreignId('order_id')->constrained()->onDelete('cascade');
            $table->foreignId('product_id')->constrained()->onDelete('cascade');
            $table->string('product_name')->nullable(); // Store product name at time of order
            $table->decimal('product_price', 10, 2)->nullable(); // Store price at time of order
            $table->string('product_image')->nullable(); // Store image path at time of order
            $table->integer('quantity')->nullable();
            $table->decimal('subtotal', 10, 2)->nullable(); // price * quantity
            $table->timestamps();
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('order_items');
    }
};
