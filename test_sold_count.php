<?php

// Test script to verify sold_count functionality
require_once 'vendor/autoload.php';

use Illuminate\Support\Facades\DB;

// Load Laravel environment
$app = require_once 'bootstrap/app.php';
$kernel = $app->make(Illuminate\Contracts\Http\Kernel::class);
$response = $kernel->handle(
    $request = Illuminate\Http\Request::capture()
);

echo "Testing sold_count functionality...\n\n";

// Check if products table has sold_count column
try {
    $hasColumn = DB::getSchemaBuilder()->hasColumn('products', 'sold_count');
    echo "✓ Products table has sold_count column: " . ($hasColumn ? 'Yes' : 'No') . "\n";
    
    // Show some sample products with sold_count
    $products = DB::table('products')->select('id', 'name', 'sold_count')->limit(5)->get();
    echo "\nSample products with sold_count:\n";
    foreach ($products as $product) {
        echo "- {$product->name}: {$product->sold_count} sold\n";
    }
    
    // Show orders with different statuses
    $orderStatuses = DB::table('orders')
        ->select('status', DB::raw('count(*) as count'))
        ->groupBy('status')
        ->get();
    
    echo "\nOrder statuses:\n";
    foreach ($orderStatuses as $status) {
        echo "- {$status->status}: {$status->count} orders\n";
    }
    
} catch (Exception $e) {
    echo "✗ Error: " . $e->getMessage() . "\n";
}

echo "\n✓ Test completed successfully!\n";
