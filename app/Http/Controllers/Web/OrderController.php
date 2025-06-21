<?php

namespace App\Http\Controllers\Web;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\Order;
use App\Models\OrderItem;
use App\Models\Product;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Log;

class OrderController extends BaseController
{
    public function view()
    {
        return view('web.order', $this->withBanners());
    }
    
    public function storeWebOrders(Request $request)
    {
        try {
            // Validate the request
            $validated = $request->validate([
                'firstName' => 'required|string|max:255',
                'lastName' => 'required|string|max:255',
                'email' => 'required|email|max:255',
                'phone' => 'required',
                'postalCode' => 'required',
                'city' => 'required|string|max:255',
                'country' => 'required|string|max:255',
                'order_items' => 'required|string', // JSON string
                'total' => 'required|numeric|min:0'
            ]);

            DB::beginTransaction();

            // Parse and validate order items
            $orderItems = json_decode($validated['order_items'], true);
            
            if (!$orderItems || !is_array($orderItems) || count($orderItems) === 0) {
                return back()->with('error', 'Your cart is empty. Please add items before placing an order.');
            }

            // Validate each item and calculate total from backend
            $calculatedTotal = 0;
            $validatedItems = [];

            foreach ($orderItems as $item) {
                // Validate item structure
                if (!isset($item['id'], $item['name'], $item['price'], $item['quantity'])) {
                    return back()->with('error', 'Invalid cart data. Please refresh and try again.');
                }

                // Verify product exists and is active
                $product = Product::find($item['id']);
                if (!$product || !$product->status) {
                    return back()->with('error', "Product '{$item['name']}' is no longer available.");
                }

                // Check stock availability
                if ($product->stock < $item['quantity']) {
                    return back()->with('error', "Insufficient stock for '{$product->name}'. Available: {$product->stock}");
                }

                // Use current product price for security
                $itemSubtotal = $product->price * $item['quantity'];
                $calculatedTotal += $itemSubtotal;

                // Prepare item data for order_items table
                $validatedItems[] = [
                    'product_id' => $product->id,
                    'product_name' => $product->name,
                    'product_price' => $product->price,
                    'product_image' => $item['image'] ?? $product->image,
                    'quantity' => (int) $item['quantity'],
                    'subtotal' => $itemSubtotal
                ];
            }

            // Security check: verify total matches calculated total
            if (abs($calculatedTotal - $validated['total']) > 0.01) {
                return back()->with('error', 'Price mismatch detected. Please refresh your cart and try again.');
            }

            // Create the order (without order_items field since we'll use separate table)
            $orderData = [
                'first_name' => $validated['firstName'],
                'last_name' => $validated['lastName'],
                'email' => $validated['email'],
                'phone' => $validated['phone'],
                'postal_code' => $validated['postalCode'],
                'city' => $validated['city'],
                'country' => $validated['country'],
                'total' => $calculatedTotal,
                'status' => 'pending'
            ];

            // Add address if provided and field exists
            if (isset($validated['address'])) {
                $orderData['address'] = $validated['address'];
            }

            $order = Order::create($orderData);

            // Create order items in separate table
            foreach ($validatedItems as $itemData) {
                $itemData['order_id'] = $order->id; // Add order_id
                OrderItem::create($itemData);
            }

            // Update product stock
            foreach ($validatedItems as $item) {
                Product::where('id', $item['product_id'])
                    ->decrement('stock', $item['quantity']);
            }

            DB::commit();

            // Log successful order
            Log::info('Order created successfully', [
                'order_id' => $order->id,
                'customer_email' => $order->email,
                'total' => $order->total,
                'items_count' => count($validatedItems)
            ]);

            return redirect()->route('web.view.index')
                ->with('success', "Order #{$order->id} placed successfully! We'll send you a confirmation email shortly.");

        } catch (\Illuminate\Validation\ValidationException $e) {
            DB::rollback();
            return back()
                ->withErrors($e->validator)
                ->withInput()
                ->with('error', 'Please check the form and try again.');
                
        } catch (\Exception $e) {
            DB::rollback();
            
            // Log the error for debugging
            Log::error('Order creation failed', [
                'error' => $e->getMessage(),
                'email' => $request->email ?? 'unknown',
                'line' => $e->getLine(),
                'file' => $e->getFile()
            ]);
            
            return back()
                ->with('error', 'Failed to place order. Please try again. If the problem persists, contact support.')
                ->withInput();
        }
    }
}