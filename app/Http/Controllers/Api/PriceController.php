<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Models\Product;
use App\Models\DealOfTheDay;
use Illuminate\Http\Request;

class PriceController extends Controller
{
    /**
     * Get current price for a product (including any active deals)
     */
    public function getCurrentPrice($productId)
    {
        $product = Product::find($productId);
        
        if (!$product) {
            return response()->json(['error' => 'Product not found'], 404);
        }

        $effectivePrice = round($product->price, 0);
        $isDeal = false;
        
        // Check for active deals
        $deal = DealOfTheDay::where('product_id', $product->id)
            ->where('is_active', 1)
            ->where('start_date', '<=', now())
            ->where('end_date', '>=', now())
            ->first();
            
        if ($deal) {
            $effectivePrice = round($deal->final_price, 0);
            $isDeal = true;
        }

        return response()->json([
            'product_id' => $product->id,
            'regular_price' => round($product->price, 0),
            'effective_price' => $effectivePrice,
            'is_deal' => $isDeal,
            'deal_info' => $deal ? [
                'discount_percentage' => $deal->discount_percentage,
                'deal_title' => $deal->deal_title,
                'end_date' => $deal->end_date->toISOString()
            ] : null
        ]);
    }

    /**
     * Validate cart totals
     */
    public function validateCart(Request $request)
    {
        $items = $request->input('items', []);
        $submittedTotal = $request->input('total', 0);
        
        $calculatedSubtotal = 0;
        $validatedItems = [];
        
        foreach ($items as $item) {
            $product = Product::find($item['id']);
            if (!$product) {
                continue;
            }
            
            $effectivePrice = round($product->price, 0);
            $isDeal = false;
            
            // Check for active deals
            $deal = DealOfTheDay::where('product_id', $product->id)
                ->where('is_active', 1)
                ->where('start_date', '<=', now())
                ->where('end_date', '>=', now())
                ->first();
                
            if ($deal) {
                $effectivePrice = round($deal->final_price, 0);
                $isDeal = true;
            }
            
            $itemSubtotal = $effectivePrice * (int)$item['quantity'];
            $calculatedSubtotal += $itemSubtotal;
            
            $validatedItems[] = [
                'id' => $product->id,
                'name' => $product->name,
                'price' => $effectivePrice,
                'quantity' => (int)$item['quantity'],
                'subtotal' => $itemSubtotal,
                'is_deal' => $isDeal
            ];
        }
        
        // Calculate shipping
        $shippingCharges = round((float) \App\Models\Setting::get('shipping_charges', '150.00'), 0);
        $freeShippingThreshold = round((float) \App\Models\Setting::get('free_shipping_threshold', '5000.00'), 0);
        
        $shippingCost = 0;
        if ($calculatedSubtotal >= $freeShippingThreshold) {
            $shippingCost = 0;
        } else if ($calculatedSubtotal > 0) {
            $shippingCost = $shippingCharges;
        }
        
        $calculatedTotal = $calculatedSubtotal + $shippingCost;
        
        return response()->json([
            'subtotal' => $calculatedSubtotal,
            'shipping_cost' => $shippingCost,
            'total' => $calculatedTotal,
            'submitted_total' => $submittedTotal,
            'is_valid' => abs($calculatedTotal - $submittedTotal) <= 10, // Increased to 10 PKR tolerance
            'difference' => abs($calculatedTotal - $submittedTotal),
            'items' => $validatedItems,
            'shipping_info' => [
                'shipping_charges' => $shippingCharges,
                'free_shipping_threshold' => $freeShippingThreshold,
                'qualifies_for_free_shipping' => $calculatedSubtotal >= $freeShippingThreshold
            ]
        ]);
    }
}
