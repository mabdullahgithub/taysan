<?php

namespace Database\Seeders;

use App\Models\Banner;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Facades\File;

class BannerSeeder extends Seeder
{
    public function run()
    {
        $bannerTypes = [
            'home' => 'home.png',
            'shop' => 'shop.png',
            'about' => 'about.png',
            'contact' => 'contact.png'
        ];

        foreach ($bannerTypes as $type => $image) {
            // Copy default images to storage
            $sourcePath = database_path('seeders/images/' . $image);
            $destinationPath = 'banners/' . $image;
            
            if (File::exists($sourcePath)) {
                Storage::disk('public')->put($destinationPath, File::get($sourcePath));

                Banner::create([
                    'type' => $type,
                    'image' => $destinationPath,
                    'title' => ucfirst($type) . ' Page',
                    'subtitle' => 'Welcome to our ' . ucfirst($type) . ' page'
                ]);
            }
        }
    }
}