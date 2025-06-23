<?php

namespace Database\Seeders;

use App\Models\Announcement;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class AnnouncementSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $announcements = [
            [
                'title' => 'New Year Sale',
                'subtitle' => 'Up to 50% off on all products',
                'description' => 'Start the new year with amazing discounts on our entire collection. Limited time offer!',
                'type' => 'sale',
                'background_color' => '#FF6B6B',
                'text_color' => '#FFFFFF',
                'button_text' => 'Shop Now',
                'button_link' => '/products',
                'countdown_date' => now()->addDays(7),
                'is_active' => true,
                'order' => 1,
                'display_duration' => 5000,
                'start_date' => now()->subDays(1),
                'end_date' => now()->addDays(7),
            ],
            [
                'title' => 'Product Launch',
                'subtitle' => 'Introducing our latest collection',
                'description' => 'Discover our newest products with innovative features and modern design.',
                'type' => 'product_launch',
                'background_color' => '#4ECDC4',
                'text_color' => '#FFFFFF',
                'button_text' => 'View Collection',
                'button_link' => '/new-arrivals',
                'is_active' => true,
                'order' => 2,
                'display_duration' => 6000,
                'start_date' => now(),
                'end_date' => now()->addDays(14),
            ],
            [
                'title' => 'Special Event',
                'subtitle' => 'Join us for an exclusive event',
                'description' => 'Don\'t miss our special event featuring live demonstrations and exclusive offers.',
                'type' => 'event',
                'background_color' => '#8B7BA8',
                'text_color' => '#FFFFFF',
                'button_text' => 'Register Now',
                'button_link' => '/events',
                'countdown_date' => now()->addDays(3),
                'is_active' => false,
                'order' => 3,
                'display_duration' => 7000,
                'start_date' => now()->addDays(1),
                'end_date' => now()->addDays(5),
            ],
        ];

        foreach ($announcements as $announcement) {
            Announcement::create($announcement);
        }
    }
}
