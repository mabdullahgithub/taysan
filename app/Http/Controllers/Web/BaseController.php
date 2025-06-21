<?php

namespace App\Http\Controllers\Web;

use App\Services\BannerService;
use App\Http\Controllers\Controller;
use App\Models\Setting;

class BaseController extends Controller
{
    protected $bannerService;
    protected $banners;

    public function __construct(BannerService $bannerService)
    {
        $this->bannerService = $bannerService;
        $this->banners = $this->bannerService->getAllBanners();
    }

    protected function withBanners($data = [])
    {
        return array_merge($data, $this->banners);
    }

    /**
     * Get shipping settings for views
     */
    protected function getShippingSettings()
    {
        return [
            'shippingCharges' => Setting::get('shipping_charges', '150.00'),
            'freeShippingThreshold' => Setting::get('free_shipping_threshold', '5000.00')
        ];
    }

    /**
     * Get data with banners and shipping settings
     */
    protected function withBannersAndShipping($data = [])
    {
        return array_merge($data, $this->banners, $this->getShippingSettings());
    }
}