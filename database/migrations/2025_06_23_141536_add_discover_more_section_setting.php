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
        // Insert the default setting for discover more section
        \App\Models\Setting::updateOrCreate(
            ['key' => 'discover_more_section_enabled'],
            ['value' => '1', 'type' => 'boolean']
        );
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        // Remove the setting
        \App\Models\Setting::where('key', 'discover_more_section_enabled')->delete();
    }
};
