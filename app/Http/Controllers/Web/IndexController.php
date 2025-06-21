<?php

namespace App\Http\Controllers\Web;

use App\Http\Controllers\Web\BaseController;
use Illuminate\Http\Request;
use App\Models\Product;
use App\Models\Category;

class IndexController extends BaseController
{

    
    public function index()
    {

        $categories = Category::all();
        //applyjoin query to get product with category name
        $products = Product::with('category')->get();
        return view('web.index', $this->withBanners([
            'products' => $products,
            'categories' => $categories
        ]));
    }
}
