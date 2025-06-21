<?php

namespace App\Http\Controllers\Web;

use App\Services\BannerService;
use App\Http\Controllers\Controller;

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
}