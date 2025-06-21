<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;
use Illuminate\Support\Facades\DB;

return new class extends Migration
{
    /**
     * Run the migrations.
     */
    public function up(): void
    {
        // Add a temporary string column
        Schema::table('products', function (Blueprint $table) {
            $table->string('status_temp')->default('active')->after('status');
        });

        // Get all products and convert boolean status to string
        $products = DB::table('products')->get();
        foreach ($products as $product) {
            $stringStatus = $product->status ? 'active' : 'inactive';
            DB::table('products')
                ->where('id', $product->id)
                ->update(['status_temp' => $stringStatus]);
        }

        // Drop the old boolean column
        Schema::table('products', function (Blueprint $table) {
            $table->dropColumn('status');
        });

        // Rename the temp column to status
        Schema::table('products', function (Blueprint $table) {
            $table->renameColumn('status_temp', 'status');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        // Add a temporary boolean column
        Schema::table('products', function (Blueprint $table) {
            $table->boolean('status_temp')->default(true)->after('status');
        });

        // Get all products and convert string status back to boolean
        $products = DB::table('products')->get();
        foreach ($products as $product) {
            $booleanStatus = $product->status === 'active' ? true : false;
            DB::table('products')
                ->where('id', $product->id)
                ->update(['status_temp' => $booleanStatus]);
        }

        // Drop the string column
        Schema::table('products', function (Blueprint $table) {
            $table->dropColumn('status');
        });

        // Rename the temp column to status
        Schema::table('products', function (Blueprint $table) {
            $table->renameColumn('status_temp', 'status');
        });
    }
};
