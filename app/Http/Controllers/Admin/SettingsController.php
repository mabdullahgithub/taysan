<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\Banner;
use App\Models\Setting;
use App\Models\Category;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Facades\Log;

class SettingsController extends Controller
{
    public function index()
    {
        $banners = [
            'homeBanner' => Banner::where('type', 'home')->first(),
            'shopBanner' => Banner::where('type', 'shop')->first(),
            'aboutBanner' => Banner::where('type', 'about')->first(),
            'contactBanner' => Banner::where('type', 'contact')->first(),
            'checkoutBanner' => Banner::where('type', 'checkout')->first(),
            'midPhotoBanner' => Banner::where('type', 'mid_photo')->first(),
            'leftImageBanner' => Banner::where('type', 'left_image')->first(),
            'rightImageBanner' => Banner::where('type', 'right_image')->first(),
            'weekendSaleGif' => Banner::where('type', 'weekend_sale_gif')->first(),
        ];

        // Get current settings
        $settings = [
            'site_title' => Setting::get('site_title', 'Taysan Beauty - Natural Handcrafted Soaps & Skincare'),
            'site_description' => Setting::get('site_description', 'Your trusted destination for natural beauty products. We specialize in handcrafted soaps and organic skincare made with love and pure ingredients.'),
            'site_keywords' => Setting::get('site_keywords', 'natural soap, handcrafted skincare, organic beauty products, Taysan Beauty'),
            'site_author' => Setting::get('site_author', 'Taysan Beauty'),
            'marquee_text' => Setting::get('marquee_text', 'Welcome to Taysan Beauty - Natural Handcrafted Soaps & Skincare Products'),
            'logo' => Setting::get('logo', ''),
            'ceo_image' => Setting::get('ceo_image', ''),
            'shipping_charges' => Setting::get('shipping_charges', '150.00'),
            'free_shipping_threshold' => Setting::get('free_shipping_threshold', '5000.00'),
            'footer_company_description' => Setting::get('footer_company_description', 'Your trusted destination for natural beauty products. We specialize in handcrafted soaps and organic skincare made with love and pure ingredients.'),
            'footer_founder_name' => Setting::get('footer_founder_name', 'Muhammad Abdullah'),
            'footer_founder_title' => Setting::get('footer_founder_title', 'Founder & CEO'),
            'footer_address' => Setting::get('footer_address', 'Lahore, Pakistan'),
            'footer_phone' => Setting::get('footer_phone', '+92 311 5904288'),
            'footer_whatsapp' => Setting::get('footer_whatsapp', 'https://wa.me/923115904288'),
            'footer_email' => Setting::get('footer_email', 'info@taysan.co'),
            'footer_facebook' => Setting::get('footer_facebook', '#'),
            'footer_instagram' => Setting::get('footer_instagram', '#'),
            'footer_twitter' => Setting::get('footer_twitter', '#'),
            'footer_copyright' => Setting::get('footer_copyright', 'Copyright © 2025 by Taysan Beauty. All Rights Reserved. | Founded by Muhammad Abdullah'),
            'discover_more_section_enabled' => Setting::get('discover_more_section_enabled', '1'),
            'discover_more_products_count' => Setting::get('discover_more_products_count', '10'),
        ];

        // Get all categories
        $categories = Category::orderBy('name')->get();
    
        return view('admin.settings', array_merge($banners, $settings, ['categories' => $categories]));
    }

    public function updateBanners(Request $request)
    {
        $request->validate([
            'home_banner' => 'nullable|image|mimes:jpeg,png,jpg,gif|max:8192',
            'shop_banner' => 'nullable|image|mimes:jpeg,png,jpg,gif|max:8192',
            'about_banner' => 'nullable|image|mimes:jpeg,png,jpg,gif|max:8192',
            'contact_banner' => 'nullable|image|mimes:jpeg,png,jpg,gif|max:8192',
            'checkout_banner' => 'nullable|image|mimes:jpeg,png,jpg,gif|max:8192',
            'mid_photo' => 'nullable|image|mimes:jpeg,png,jpg,gif|max:8192',
            'left_image' => 'nullable|image|mimes:jpeg,png,jpg,gif|max:8192',
            'right_image' => 'nullable|image|mimes:jpeg,png,jpg,gif|max:8192',
            'weekend_sale_gif' => 'nullable|image|mimes:jpeg,png,jpg,gif|max:8192',
            
            // Title validations
            'home_title' => 'nullable|string|max:255',
            'shop_title' => 'nullable|string|max:255',
            'about_title' => 'nullable|string|max:255',
            'contact_title' => 'nullable|string|max:255',
            'checkout_title' => 'nullable|string|max:255',
            'mid_title' => 'nullable|string|max:255',
            'left_title' => 'nullable|string|max:255',
            'right_title' => 'nullable|string|max:255',
            'weekend_sale_title' => 'nullable|string|max:255',
            
            // Subtitle validations
            'home_subtitle' => 'nullable|string|max:255',
            'shop_subtitle' => 'nullable|string|max:255',
            'about_subtitle' => 'nullable|string|max:255',
            'contact_subtitle' => 'nullable|string|max:255',
            'checkout_subtitle' => 'nullable|string|max:255',
            'mid_subtitle' => 'nullable|string|max:255',
            'left_subtitle' => 'nullable|string|max:255',
            'right_subtitle' => 'nullable|string|max:255',
            'weekend_sale_subtitle' => 'nullable|string|max:255',
        ]);

        $bannerConfigs = [
            [
                'type' => 'home',
                'image_key' => 'home_banner',
                'title_key' => 'home_title',
                'subtitle_key' => 'home_subtitle'
            ],
            [
                'type' => 'shop',
                'image_key' => 'shop_banner',
                'title_key' => 'shop_title',
                'subtitle_key' => 'shop_subtitle'
            ],
            [
                'type' => 'about',
                'image_key' => 'about_banner',
                'title_key' => 'about_title',
                'subtitle_key' => 'about_subtitle'
            ],
            [
                'type' => 'contact',
                'image_key' => 'contact_banner',
                'title_key' => 'contact_title',
                'subtitle_key' => 'contact_subtitle'
            ],
            [
                'type' => 'checkout',
                'image_key' => 'checkout_banner',
                'title_key' => 'checkout_title',
                'subtitle_key' => 'checkout_subtitle'
            ],
            [
                'type' => 'mid_photo',
                'image_key' => 'mid_photo',
                'title_key' => 'mid_title',
                'subtitle_key' => 'mid_subtitle'
            ],
            [
                'type' => 'left_image',
                'image_key' => 'left_image',
                'title_key' => 'left_title',
                'subtitle_key' => 'left_subtitle'
            ],
            [
                'type' => 'right_image',
                'image_key' => 'right_image',
                'title_key' => 'right_title',
                'subtitle_key' => 'right_subtitle'
            ],
            [
                'type' => 'weekend_sale_gif',
                'image_key' => 'weekend_sale_gif',
                'title_key' => 'weekend_sale_title',
                'subtitle_key' => 'weekend_sale_subtitle'
            ]
        ];


        foreach ($bannerConfigs as $config) {
            $banner = Banner::firstOrCreate(['type' => $config['type']]);
            
            // Handle image upload
            if ($request->hasFile($config['image_key'])) {
                // Delete old image if exists
                if ($banner->image) {
                    Storage::disk('public')->delete($banner->image);
                }
                
                $file = $request->file($config['image_key']);
                $filename = $config['type'] . '_' . time() . '.' . $file->getClientOriginalExtension();
                $path = $file->storeAs('banners', $filename, 'public');
                $banner->image = $path;
                
                // Debug log for checkout banner
                if ($config['type'] === 'checkout') {
                    Log::info('Checkout banner image updated', [
                        'filename' => $filename,
                        'path' => $path,
                        'file_size' => $file->getSize()
                    ]);
                }
            }
            
            // Update title and subtitle
            $banner->title = $request->input($config['title_key'], $banner->title);
            $banner->subtitle = $request->input($config['subtitle_key'], $banner->subtitle);
            $banner->save();
            
            // Debug log for checkout banner save
            if ($config['type'] === 'checkout') {
                Log::info('Checkout banner saved', [
                    'id' => $banner->id,
                    'image' => $banner->image,
                    'title' => $banner->title,
                    'subtitle' => $banner->subtitle
                ]);
            }
        }

        return redirect()->back()->with('success', 'All banners and images have been updated successfully!');
    }

    public function updateSettings(Request $request)
    {
        $request->validate([
            'site_title' => 'nullable|string|max:255',
            'site_description' => 'nullable|string|max:500',
            'site_keywords' => 'nullable|string|max:255',
            'site_author' => 'nullable|string|max:255',
            'marquee_text' => 'nullable|string|max:500',
            'logo' => 'nullable|image|mimes:jpeg,png,jpg,gif,svg|max:8192',
            'ceo_image' => 'nullable|image|mimes:jpeg,png,jpg,gif,svg|max:8192',
            'shipping_charges' => 'nullable|numeric|min:0|max:99999.99',
            'free_shipping_threshold' => 'nullable|numeric|min:0|max:999999.99',
            'footer_company_description' => 'nullable|string|max:500',
            'footer_founder_name' => 'nullable|string|max:255',
            'footer_founder_title' => 'nullable|string|max:255',
            'footer_address' => 'nullable|string|max:255',
            'footer_phone' => 'nullable|string|max:255',
            'footer_whatsapp' => 'nullable|url|max:255',
            'footer_email' => 'nullable|email|max:255',
            'footer_facebook' => 'nullable|url|max:255',
            'footer_instagram' => 'nullable|url|max:255',
            'footer_twitter' => 'nullable|url|max:255',
            'footer_copyright' => 'nullable|string|max:255',
            'discover_more_products_count' => 'nullable|integer|min:1|max:50',
        ]);

        $settingsMap = [
            'site_title' => 'text',
            'site_description' => 'textarea',
            'site_keywords' => 'text',
            'site_author' => 'text',
            'marquee_text' => 'text',
            'shipping_charges' => 'number',
            'free_shipping_threshold' => 'number',
            'footer_company_description' => 'textarea',
            'footer_founder_name' => 'text',
            'footer_founder_title' => 'text',
            'footer_address' => 'text',
            'footer_phone' => 'text',
            'footer_whatsapp' => 'url',
            'footer_email' => 'email',
            'footer_facebook' => 'url',
            'footer_instagram' => 'url',
            'footer_twitter' => 'url',
            'footer_copyright' => 'text',
            'discover_more_products_count' => 'number',
        ];

        // Update text settings
        foreach ($settingsMap as $key => $type) {
            if ($request->has($key)) {
                Setting::set($key, $request->input($key), $type);
            }
        }

        // Handle checkbox settings (checkboxes don't send value when unchecked)
        Setting::set('discover_more_section_enabled', $request->has('discover_more_section_enabled') ? '1' : '0', 'boolean');
        
        // Handle number settings that may not be in the settingsMap
        if ($request->has('discover_more_products_count')) {
            Setting::set('discover_more_products_count', $request->input('discover_more_products_count'), 'number');
        }

        // Handle logo upload
        if ($request->hasFile('logo')) {
            // Delete old logo if exists
            $oldLogo = Setting::get('logo');
            if ($oldLogo) {
                Storage::disk('public')->delete($oldLogo);
            }
            
            $file = $request->file('logo');
            $filename = 'logo_' . time() . '.' . $file->getClientOriginalExtension();
            $path = $file->storeAs('logos', $filename, 'public');
            Setting::set('logo', $path, 'image');
        }

        // Handle CEO image upload
        if ($request->hasFile('ceo_image')) {
            // Delete old CEO image if exists
            $oldCeoImage = Setting::get('ceo_image');
            if ($oldCeoImage) {
                Storage::disk('public')->delete($oldCeoImage);
            }
            
            $file = $request->file('ceo_image');
            $filename = 'ceo_' . time() . '.' . $file->getClientOriginalExtension();
            $path = $file->storeAs('team', $filename, 'public');
            Setting::set('ceo_image', $path, 'image');
        }

        return redirect()->back()->with('success', 'Settings have been updated successfully!');
    }

    // Category CRUD Methods
    public function storeCategory(Request $request)
    {
        $request->validate([
            'name' => 'required|string|max:255|unique:categories,name',
        ]);

        Category::create([
            'name' => $request->name,
        ]);

        return redirect()->back()->with('success', 'Category created successfully!');
    }

    public function updateCategory(Request $request, Category $category)
    {
        $request->validate([
            'name' => 'required|string|max:255|unique:categories,name,' . $category->id,
        ]);

        $category->update([
            'name' => $request->name,
        ]);

        return redirect()->back()->with('success', 'Category updated successfully!');
    }

    public function destroyCategory(Category $category)
    {
        // Check if category has products
        if ($category->products()->exists()) {
            return redirect()->back()->with('error', 'Cannot delete category with existing products. Please move or delete products first.');
        }

        $category->delete();

        return redirect()->back()->with('success', 'Category deleted successfully!');
    }
}