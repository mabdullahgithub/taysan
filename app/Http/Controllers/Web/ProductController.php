<?php

namespace App\Http\Controllers\Web;

use App\Http\Controllers\Controller;
use App\Models\Product;
use App\Models\DealOfTheDay;
use App\Models\Banner;
use Illuminate\Http\Request;

class ProductController extends BaseController
{
    public function show(Product $product, Request $request)
    {
        // Check if product is active
        if ($product->status !== 'active') {
            abort(404);
        }

        // Check if there's an active deal for this product
        $deal = DealOfTheDay::where('product_id', $product->id)
            ->where('is_active', 1)
            ->where('start_date', '<=', now())
            ->where('end_date', '>=', now())
            ->first();

        // Check if accessed from deal page
        $fromDeal = $request->get('from') === 'deal' && $deal;

        // Get related products from same category
        $relatedProducts = Product::where('category_id', $product->category_id)
            ->where('id', '!=', $product->id)
            ->where('status', 'active')
            ->inRandomOrder()
            ->take(8)
            ->get();

        // If not enough products in same category, get from other categories
        if ($relatedProducts->count() < 4) {
            $additionalProducts = Product::where('category_id', '!=', $product->category_id)
                ->where('id', '!=', $product->id)
                ->where('status', 'active')
                ->inRandomOrder()
                ->take(8 - $relatedProducts->count())
                ->get();
            
            $relatedProducts = $relatedProducts->merge($additionalProducts);
        }

        // Get banners for the page
        $banners = $this->withBannersAndShipping();

        return view('web.product.show', compact('product', 'deal', 'relatedProducts', 'fromDeal') + $banners);
    }
}
