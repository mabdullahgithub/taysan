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
        //applyjoin query to get product with category name - only show active products
        $products = Product::with('category')->where('status', 'active')->get();
        
        // Get active deals (limit to 3 for the deal section)
        // Removed product status check to allow Shop Now button to work regardless of product status
        $deals = DealOfTheDay::with('product')
                            ->active()
                            ->orderBy('sort_order')
                            ->take(3)
                            ->get();
        
        return view('web.index', $this->withBanners([
            'products' => $products,
            'categories' => $categories,
            'deals' => $deals
        ]));
    }
}
