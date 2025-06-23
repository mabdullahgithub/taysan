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
        // Insert the default setting for discover more products count
        \App\Models\Setting::updateOrCreate(
            ['key' => 'discover_more_products_count'],
            ['value' => '10', 'type' => 'number']
        );
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        // Remove the setting
        \App\Models\Setting::where('key', 'discover_more_products_count')->delete();
    }
};
