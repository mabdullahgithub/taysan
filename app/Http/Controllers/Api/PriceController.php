<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\Product;
use App\Models\DealOfTheDay;
use App\Models\Setting;
use Illuminate\Support\Facades\Log;

class PriceController extends Controller
{
    /**
     * Validate cart items and calculate accurate totals
     */
    public function validateCart(Request $request)
    {
        try {
            $items = $request->input('items', []);
            $submittedTotal = $request->input('total', 0);
            
            if (empty($items)) {
                return response()->json([
                    'is_valid' => false,
                    'message' => 'Cart is empty',
                    'subtotal' => 0,
                    'shipping_cost' => 0,
                    'total' => 0,
                    'difference' => 0
                ]);
            }
            
            $calculatedSubtotal = 0;
            $validatedItems = [];
            
            foreach ($items as $item) {
                // Validate item structure
                if (!isset($item['id'], $item['quantity'])) {
                    continue;
                }
                
                $product = Product::find($item['id']);
                if (!$product || $product->status !== 'active') {
                    continue;
                }
                
                // Get effective price (deal price or regular price)
                $effectivePrice = $product->price;
                $deal = DealOfTheDay::where('product_id', $product->id)
                    ->where('is_active', 1)
                    ->where('start_date', '<=', now())
                    ->where('end_date', '>=', now())
                    ->first();
                    
                if ($deal) {
                    $effectivePrice = $deal->final_price;
                }
                
                // Round to whole numbers
                $effectivePrice = round($effectivePrice, 0);
                $itemSubtotal = $effectivePrice * (int)$item['quantity'];
                $calculatedSubtotal += $itemSubtotal;
                
                $validatedItems[] = [
                    'id' => $product->id,
                    'name' => $product->name,
                    'price' => $effectivePrice,
                    'quantity' => (int)$item['quantity'],
                    'subtotal' => $itemSubtotal
                ];
            }
            
            // Round subtotal
            $calculatedSubtotal = round($calculatedSubtotal, 0);
            
            // Calculate shipping
            $shippingCharges = round((float) Setting::get('shipping_charges', '150.00'), 0);
            $freeShippingThreshold = round((float) Setting::get('free_shipping_threshold', '5000.00'), 0);
            
            $shippingCost = 0;
            if ($calculatedSubtotal >= $freeShippingThreshold) {
                $shippingCost = 0; // Free shipping
            } else if ($calculatedSubtotal > 0) {
                $shippingCost = $shippingCharges;
            }
            
            $shippingCost = round($shippingCost, 0);
            $calculatedTotal = round($calculatedSubtotal + $shippingCost, 0);
            
            // Check if prices match (with tolerance)
            $tolerance = 5; // 5 PKR tolerance
            $difference = abs($calculatedTotal - $submittedTotal);
            $isValid = $difference <= $tolerance;
            
            Log::info('Cart validation', [
                'submitted_total' => $submittedTotal,
                'calculated_total' => $calculatedTotal,
                'difference' => $difference,
                'is_valid' => $isValid,
                'subtotal' => $calculatedSubtotal,
                'shipping_cost' => $shippingCost,
                'items_count' => count($validatedItems)
            ]);
            
            return response()->json([
                'is_valid' => $isValid,
                'subtotal' => $calculatedSubtotal,
                'shipping_cost' => $shippingCost,
                'total' => $calculatedTotal,
                'difference' => $difference,
                'items' => $validatedItems,
                'message' => $isValid ? 'Cart is valid' : "Price mismatch detected. Calculated: PKR " . number_format($calculatedTotal) . ", Submitted: PKR " . number_format($submittedTotal) . ". Please refresh your cart and try again."
            ]);
            
        } catch (\Exception $e) {
            Log::error('Cart validation error', [
                'error' => $e->getMessage(),
                'line' => $e->getLine()
            ]);
            
            return response()->json([
                'is_valid' => false,
                'message' => 'Validation error occurred',
                'subtotal' => 0,
                'shipping_cost' => 0,
                'total' => 0,
                'difference' => 0
            ], 500);
        }
    }
}