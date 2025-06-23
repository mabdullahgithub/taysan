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
        Schema::table('products', function (Blueprint $table) {
            $table->text('detailed_description')->nullable()->after('description');
            $table->json('images')->nullable()->after('image'); // Store multiple images as JSON
            $table->string('sku')->nullable()->after('name');
            $table->decimal('weight', 8, 2)->nullable()->after('price');
            $table->string('dimensions')->nullable()->after('weight');
            $table->text('ingredients')->nullable()->after('detailed_description');
            $table->text('benefits')->nullable()->after('ingredients');
            $table->text('usage_instructions')->nullable()->after('benefits');
            $table->string('origin_country')->nullable()->after('usage_instructions');
            $table->boolean('is_organic')->default(false)->after('origin_country');
            $table->boolean('is_vegan')->default(false)->after('is_organic');
            $table->boolean('is_cruelty_free')->default(false)->after('is_vegan');
            $table->json('tags')->nullable()->after('is_cruelty_free'); // Store tags as JSON
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('products', function (Blueprint $table) {
            $table->dropColumn([
                'detailed_description',
                'images',
                'sku',
                'weight',
                'dimensions',
                'ingredients',
                'benefits',
                'usage_instructions',
                'origin_country',
                'is_organic',
                'is_vegan',
                'is_cruelty_free',
                'tags'
            ]);
        });
    }
};
