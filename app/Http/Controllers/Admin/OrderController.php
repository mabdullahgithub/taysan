<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Order;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Log;

class OrderController extends Controller
{
    /**
     * Display a listing of orders
     */
    public function index(Request $request)
    {
        $query = Order::with(['orderItems', 'orderItems.product']);
        
        // Filter by status if provided
        if ($request->has('status') && $request->status !== 'all') {
            $query->where('status', $request->status);
        }
        
        // Filter by shipping type if provided
        if ($request->has('shipping') && $request->shipping !== 'all') {
            if ($request->shipping === 'free') {
                $query->where('shipping_cost', 0);
            } elseif ($request->shipping === 'paid') {
                $query->where('shipping_cost', '>', 0);
            }
        }
        
        // Filter by deal status if provided
        if ($request->has('deal') && $request->deal !== 'all') {
            if ($request->deal === 'with_deals') {
                $query->whereHas('orderItems', function($q) {
                    $q->whereHas('product', function($p) {
                        $p->whereHas('dealOfTheDay', function($d) {
                            $d->where('is_active', 1)
                              ->where('start_date', '<=', now())
                              ->where('end_date', '>=', now());
                        });
                    });
                });
            } elseif ($request->deal === 'without_deals') {
                $query->whereDoesntHave('orderItems', function($q) {
                    $q->whereHas('product', function($p) {
                        $p->whereHas('dealOfTheDay', function($d) {
                            $d->where('is_active', 1)
                              ->where('start_date', '<=', now())
                              ->where('end_date', '>=', now());
                        });
                    });
                });
            }
        }
        
        $orders = $query->orderBy('created_at', 'desc')->paginate(15);
        
        // Get order counts for filter tabs
        $orderCounts = [
            'all' => Order::count(),
            'pending' => Order::where('status', 'pending')->count(),
            'processing' => Order::where('status', 'processing')->count(),
            'shipped' => Order::where('status', 'shipped')->count(),
            'delivered' => Order::where('status', 'delivered')->count(),
            'cancelled' => Order::where('status', 'cancelled')->count(),
            'free_shipping' => Order::where('shipping_cost', 0)->count(),
            'paid_shipping' => Order::where('shipping_cost', '>', 0)->count(),
        ];
        
        return view('admin.orders.view', compact('orders', 'orderCounts'));
    }

    /**
     * Display the specified order
     */
    public function show($id)
    {
        $order = Order::with(['orderItems', 'orderItems.product'])
            ->findOrFail($id);
            
        return view('admin.orders.order-details', compact('order'));
    }

    /**
     * Update order status
     */
    public function updateStatus(Request $request, $id)
    {
        $request->validate([
            'status' => 'required|in:pending,processing,shipped,delivered,cancelled'
        ]);

        try {
            $order = Order::with('orderItems.product')->findOrFail($id);
            $oldStatus = $order->status;
            $newStatus = $request->status;
            
            $order->status = $newStatus;
            $order->save();

            // Increment sold_count for products when order status changes to 'delivered'
            if ($oldStatus !== 'delivered' && $newStatus === 'delivered') {
                foreach ($order->orderItems as $orderItem) {
                    if ($orderItem->product) {
                        $orderItem->product->increment('sold_count', $orderItem->quantity);
                    }
                }
            }

            return redirect()->route('admin.orders.show', $id)
                ->with('success', "Order status updated from '{$oldStatus}' to '{$newStatus}' successfully");
        } catch (\Illuminate\Database\Eloquent\ModelNotFoundException $e) {
            return redirect()->route('admin.orders.index')
                ->with('error', 'Order not found');
        } catch (\Exception $e) {
            Log::error('Order status update failed: ' . $e->getMessage());
            return redirect()->back()
                ->with('error', 'Failed to update order status. Please try again.');
        }
    }

    /**
     * Get order statistics for dashboard
     */
    public function getStats()
    {
        return [
            'total_orders' => Order::count(),
            'pending_orders' => Order::where('status', 'pending')->count(),
            'processing_orders' => Order::where('status', 'processing')->count(),
            'shipped_orders' => Order::where('status', 'shipped')->count(),
            'delivered_orders' => Order::where('status', 'delivered')->count(),
            'cancelled_orders' => Order::where('status', 'cancelled')->count(),
            'total_revenue' => Order::whereNotIn('status', ['cancelled'])->sum('total'),
            'monthly_revenue' => Order::whereNotIn('status', ['cancelled'])
                ->whereMonth('created_at', now()->month)
                ->sum('total'),
        ];
    }

    /**
     * Display the specified order for printing
     */
    public function print($id)
    {
        $order = Order::with(['orderItems', 'orderItems.product'])
            ->findOrFail($id);
            
        return view('admin.orders.print', compact('order'));
    }
}