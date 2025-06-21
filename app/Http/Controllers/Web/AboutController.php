<?php

namespace App\Http\Controllers\Web;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;

class AboutController extends BaseController
{
    
    public function View()
    {
        return view('web.about', $this->withBanners());
    }
}
