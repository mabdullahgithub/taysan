<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Order;
use Illuminate\Http\Request;

class OrderController extends Controller
{
    /**
     * Display a listing of orders
     */
    public function index()
    {
        $orders = Order::with('orderItems')
            ->orderBy('created_at', 'desc')
            ->paginate(15);
            
        return view('admin.orders.view', compact('orders'));
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
            $order = Order::findOrFail($id);
            $oldStatus = $order->status;
            $order->status = $request->status;
            $order->save();

            return redirect()->route('admin.orders.show', $id)
                ->with('success', "Order status updated from '{$oldStatus}' to '{$request->status}' successfully");
        } catch (\Illuminate\Database\Eloquent\ModelNotFoundException $e) {
            return redirect()->route('admin.orders.index')
                ->with('error', 'Order not found');
        } catch (\Exception $e) {
            \Log::error('Order status update failed: ' . $e->getMessage());
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
}