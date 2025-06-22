<?php

require_once 'vendor/autoload.php';

// Bootstrap Laravel
$app = require_once 'bootstrap/app.php';
$app->make(Illuminate\Contracts\Console\Kernel::class)->bootstrap();

use App\Models\Order;
use App\Models\Product;
use App\Models\DealOfTheDay;

echo "Fixing order sources for existing orders...\n";

// Get all orders marked as 'regular'
$regularOrders = Order::where('order_source', 'regular')->get();

$fixedCount = 0;

foreach ($regularOrders as $order) {
    $shouldBeDealsOrder = false;
    $dealId = null;
    
    echo "Checking Order #{$order->id} from {$order->created_at}...\n";
    
    // Check each item in the order
    foreach ($order->orderItems as $item) {
        $product = Product::find($item->product_id);
        
        if (!$product) {
            continue;
        }
        
        // Check if there was an active deal for this product at the time of order
        $deal = DealOfTheDay::where('product_id', $item->product_id)
            ->where('is_active', 1)
            ->where('start_date', '<=', $order->created_at)
            ->where('end_date', '>=', $order->created_at)
            ->first();
        
        if ($deal) {
            // Check if the customer paid the deal price
            if (abs($item->product_price - $deal->final_price) < 1) { // Allow small rounding differences
                $shouldBeDealsOrder = true;
                $dealId = $deal->id;
                echo "  - Item '{$item->product_name}': Paid {$item->product_price}, Deal price was {$deal->final_price} - DEAL DETECTED\n";
                break; // If any item is from a deal, the whole order is a deal order
            } else {
                echo "  - Item '{$item->product_name}': Paid {$item->product_price}, Deal price was {$deal->final_price} - No match\n";
            }
        } else {
            echo "  - Item '{$item->product_name}': No active deal at order time\n";
        }
    }
    
    if ($shouldBeDealsOrder) {
        // Update the order
        $order->update([
            'order_source' => 'deal',
            'deal_id' => $dealId
        ]);
        
        echo "  ✓ Fixed Order #{$order->id}: Changed from 'regular' to 'deal' (Deal ID: {$dealId})\n";
        $fixedCount++;
    } else {
        echo "  - Order #{$order->id}: Correctly marked as 'regular'\n";
    }
    
    echo "\n";
}

echo "Fixed {$fixedCount} orders.\n";
echo "Done!\n";
