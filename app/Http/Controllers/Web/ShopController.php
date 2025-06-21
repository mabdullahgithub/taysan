<?php

namespace App\Http\Controllers\Web;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\Product;
use App\Http\Controllers\Web\BaseController;
use App\Models\Category;
class ShopController extends BaseController
{
    
    public function View()
    {
        $categories = Category::all();
        //applyjoin query to get product with category name - only show active products
        $products = Product::with('category')->where('status', 'active')->get();
        return view('web.shop.shop', $this->withBanners([
            'products' => $products,
            'categories' => $categories
        ]));
    }

}
