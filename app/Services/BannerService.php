<?php

namespace App\Services;

use App\Models\Banner;

class BannerService
{
    protected $banners;

    public function __construct()
    {
        $this->loadBanners();
    }

    protected function loadBanners()
    {
        $this->banners = [
            'homeBanner' => Banner::where('type', 'home')->first(),
            'shopBanner' => Banner::where('type', 'shop')->first(),
            'aboutBanner' => Banner::where('type', 'about')->first(),
            'contactBanner' => Banner::where('type', 'contact')->first(),
            'checkoutBanner' => Banner::where('type', 'checkout')->first(),
            'midPhotoBanner' => Banner::where('type', 'home_mid_photo')->first(), // New banner type
            'leftImageBanner' => Banner::where('type', 'left_image')->first(), // New banner type
            'rightImageBanner' => Banner::where('type', 'right_image')->first(), // New banner type
        ];
    }

    public function getAllBanners()
    {
        return $this->banners;
    }
}