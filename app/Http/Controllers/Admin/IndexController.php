<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Product;
use App\Models\Order;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Carbon\Carbon;

class IndexController extends Controller
{
    /**
     * Display the admin dashboard
     */
    public function index()
    {
        // Get current date ranges
        $currentMonth = Carbon::now()->startOfMonth();
        $lastMonth = Carbon::now()->subMonth()->startOfMonth();
        $currentYear = Carbon::now()->startOfYear();
        
        // Calculate key metrics
        $totalOrders = Order::count();
        $totalRevenue = Order::whereNotIn('status', ['cancelled'])->sum('total');
        $totalProducts = Product::where('status', true)->count();
        $pendingOrders = Order::where('status', 'pending')->count();
        
        // Monthly revenue comparison
        $monthlyRevenue = Order::where('created_at', '>=', $currentMonth)
            ->whereNotIn('status', ['cancelled'])
            ->sum('total');
            
        $lastMonthRevenue = Order::whereBetween('created_at', [
                $lastMonth, 
                $lastMonth->copy()->endOfMonth()
            ])
            ->whereNotIn('status', ['cancelled'])
            ->sum('total');
        
        // Average order value
        $averageOrderValue = $totalOrders > 0 ? $totalRevenue / $totalOrders : 0;
        
        // Order status breakdown
        $orderStatusBreakdown = Order::select('status', DB::raw('count(*) as count'))
            ->groupBy('status')
            ->pluck('count', 'status')
            ->toArray();
        
        // Recent orders (last 10)
        $recentOrders = Order::with([])
            ->orderBy('created_at', 'desc')
            ->limit(10)
            ->get();
        
        // Revenue chart data (last 30 days)
        $revenueChartData = $this->getRevenueChartData();
        
        // Low stock products (stock <= 10)
        $lowStockProducts = Product::where('stock', '<=', 10)
            ->where('status', true)
            ->orderBy('stock', 'asc')
            ->limit(5)
            ->get();
        
        // Top selling products (based on order items)
        $topSellingProducts = $this->getTopSellingProducts();
        
        return view('admin.index', compact(
            'totalOrders',
            'totalRevenue',
            'totalProducts',
            'pendingOrders',
            'monthlyRevenue',
            'lastMonthRevenue',
            'averageOrderValue',
            'orderStatusBreakdown',
            'recentOrders',
            'revenueChartData',
            'lowStockProducts',
            'topSellingProducts'
        ));
    }
    
    /**
     * Get revenue chart data for the last 30 days
     */
    private function getRevenueChartData()
    {
        $days = collect();
        $revenues = collect();
        
        // Get last 30 days
        for ($i = 29; $i >= 0; $i--) {
            $date = Carbon::now()->subDays($i);
            $dayRevenue = Order::whereDate('created_at', $date)
                ->whereNotIn('status', ['cancelled'])
                ->sum('total');
            
            $days->push($date->format('M d'));
            $revenues->push($dayRevenue);
        }
        
        return [
            'labels' => $days->toArray(),
            'data' => $revenues->toArray()
        ];
    }
    
    /**
     * Get top selling products based on order frequency
     */
    private function getTopSellingProducts()
    {
        // Since order_items is stored as JSON, we need to extract and count
        $topProducts = collect();
        
        $orders = Order::whereNotNull('order_items')
            ->whereNotIn('status', ['cancelled'])
            ->get();
        
        $productCounts = [];
        
        foreach ($orders as $order) {
            $orderItems = json_decode($order->order_items, true);
            
            if (is_array($orderItems)) {
                foreach ($orderItems as $item) {
                    if (isset($item['product_id'])) {
                        $productId = $item['product_id'];
                        $quantity = $item['quantity'] ?? 1;
                        
                        if (!isset($productCounts[$productId])) {
                            $productCounts[$productId] = 0;
                        }
                        $productCounts[$productId] += $quantity;
                    }
                }
            }
        }
        
        // Sort by count and get top 5
        arsort($productCounts);
        $topProductIds = array_slice(array_keys($productCounts), 0, 5, true);
        
        // Get product details
        $products = Product::whereIn('id', $topProductIds)->get();
        
        foreach ($products as $product) {
            $product->total_sold = $productCounts[$product->id] ?? 0;
        }
        
        return $products->sortByDesc('total_sold');
    }
    
    /**
     * Get weekly comparison data
     */
    public function getWeeklyComparison()
    {
        $thisWeekStart = Carbon::now()->startOfWeek();
        $lastWeekStart = Carbon::now()->subWeek()->startOfWeek();
        $lastWeekEnd = Carbon::now()->subWeek()->endOfWeek();
        
        $thisWeekOrders = Order::where('created_at', '>=', $thisWeekStart)->count();
        $lastWeekOrders = Order::whereBetween('created_at', [$lastWeekStart, $lastWeekEnd])->count();
        
        $thisWeekRevenue = Order::where('created_at', '>=', $thisWeekStart)
            ->whereNotIn('status', ['cancelled'])
            ->sum('total');
            
        $lastWeekRevenue = Order::whereBetween('created_at', [$lastWeekStart, $lastWeekEnd])
            ->whereNotIn('status', ['cancelled'])
            ->sum('total');
        
        return [
            'orders' => [
                'current' => $thisWeekOrders,
                'previous' => $lastWeekOrders,
                'change' => $lastWeekOrders > 0 ? 
                    round((($thisWeekOrders - $lastWeekOrders) / $lastWeekOrders) * 100, 1) : 0
            ],
            'revenue' => [
                'current' => $thisWeekRevenue,
                'previous' => $lastWeekRevenue,
                'change' => $lastWeekRevenue > 0 ? 
                    round((($thisWeekRevenue - $lastWeekRevenue) / $lastWeekRevenue) * 100, 1) : 0
            ]
        ];
    }
    
    /**
     * Get sales by category
     */
    public function getSalesByCategory()
    {
        $categories = DB::table('categories')
            ->leftJoin('products', 'categories.id', '=', 'products.category_id')
            ->select('categories.name', DB::raw('count(products.id) as product_count'))
            ->groupBy('categories.id', 'categories.name')
            ->get();
        
        return $categories;
    }
    
    /**
     * Get customer growth data
     */
    public function getCustomerGrowth()
    {
        $monthlyGrowth = collect();
        
        for ($i = 11; $i >= 0; $i--) {
            $month = Carbon::now()->subMonths($i);
            $customerCount = User::whereYear('created_at', $month->year)
                ->whereMonth('created_at', $month->month)
                ->count();
            
            $monthlyGrowth->push([
                'month' => $month->format('M Y'),
                'customers' => $customerCount
            ]);
        }
        
        return $monthlyGrowth;
    }
    
    /**
     * Get system alerts (low stock, pending orders, etc.)
     */
    public function getSystemAlerts()
    {
        $alerts = collect();
        
        // Low stock alert
        $lowStockCount = Product::where('stock', '<=', 10)
            ->where('status', true)
            ->count();
            
        if ($lowStockCount > 0) {
            $alerts->push([
                'type' => 'warning',
                'message' => "{$lowStockCount} products are running low on stock",
                'action_url' => route('admin.products.index'),
                'action_text' => 'View Products'
            ]);
        }
        
        // Pending orders alert
        $pendingCount = Order::where('status', 'pending')->count();
        if ($pendingCount > 0) {
            $alerts->push([
                'type' => 'info',
                'message' => "{$pendingCount} orders are awaiting processing",
                'action_url' => route('admin.orders.index'),
                'action_text' => 'View Orders'
            ]);
        }
        
        return $alerts;
    }
}