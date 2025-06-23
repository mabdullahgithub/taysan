<?php

namespace App\Http\Controllers\Web;

use App\Http\Controllers\Web\BaseController;
use Illuminate\Http\Request;
use App\Models\Product;
use App\Models\Category;
use App\Models\DealOfTheDay;

class IndexController extends BaseController
{

    
    public function index()
    {
        $categories = Category::all();
        
        // Get all active products for general listing
        $products = Product::with('category')->where('status', 'active')->get();
        
        // Get Top Picks - prioritize by sold count, then by featured flags
        $topPicks = Product::with('category')
                          ->where('status', 'active')
                          ->where('stock', '>', 0)
                          ->where(function($query) {
                              $query->where('sold_count', '>', 0)  // Products with sales
                                    ->orWhere('flag', 'Featured')
                                    ->orWhere('flag', 'Best Seller')
                                    ->orWhere('flag', 'Top Pick');
                          })
                          ->orderByRaw('CASE 
                              WHEN sold_count > 0 THEN sold_count
                              WHEN flag = "Best Seller" THEN 1000
                              WHEN flag = "Featured" THEN 999
                              WHEN flag = "Top Pick" THEN 998
                              ELSE 0 END DESC')
                          ->limit(8)
                          ->get();
        
        // Get active deals (limit to 3 for the deal section)
        $deals = DealOfTheDay::with('product')
                            ->active()
                            ->orderBy('sort_order')
                            ->take(3)
                            ->get();

        // Get active announcements
        $announcements = \App\Models\Announcement::active()
                                                ->orderBy('order')
                                                ->orderBy('created_at', 'desc')
                                                ->get();

        // Get random products for the products showcase section (if enabled)
        $randomProducts = collect();
        if(\App\Models\Setting::get('discover_more_section_enabled', '1') == '1') {
            $productCount = (int)\App\Models\Setting::get('discover_more_products_count', '10');
            $randomProducts = Product::with('category')
                                    ->where('status', 'active')
                                    ->where('stock', '>', 0)
                                    ->inRandomOrder()
                                    ->limit($productCount)
                                    ->get();
        }
        
        return view('web.index', $this->withBanners([
            'products' => $products,
            'topPicks' => $topPicks,
            'categories' => $categories,
            'deals' => $deals,
            'announcements' => $announcements,
            'randomProducts' => $randomProducts
        ]));
    }
}
