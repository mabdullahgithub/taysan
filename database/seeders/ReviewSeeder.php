<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use App\Models\Review;
use App\Models\Product;

class ReviewSeeder extends Seeder
{
    /**
     * Run the database seeder.
     */
    public function run(): void
    {
        $products = Product::all();
        
        if ($products->isEmpty()) {
            $this->command->warn('No products found. Please create products first.');
            return;
        }

        $reviewData = [
            [
                'name' => 'Michelle A.',
                'email' => 'michelle@example.com',
                'location' => 'United States',
                'rating' => 5,
                'title' => 'They are great',
                'comment' => 'I love these lozenges. They are very soothing and delicious. I sometimes have issues with esophageal inflammation, and take them to soothe my throat. I really like them.',
                'is_verified_buyer' => true,
                'is_approved' => true,
                'order_reference' => 'ORD-2024-001',
                'reviewed_at' => now()->subDays(5)
            ],
            [
                'name' => 'Anonymous',
                'email' => 'anonymous@example.com',
                'location' => 'United States',
                'rating' => 5,
                'title' => 'Honey soothing drops',
                'comment' => 'I love love love your honey and products.',
                'is_verified_buyer' => true,
                'is_approved' => true,
                'order_reference' => 'ORD-2024-002',
                'reviewed_at' => now()->subDays(8)
            ],
            [
                'name' => 'Linda C.',
                'email' => 'linda@example.com',
                'location' => 'United States',
                'rating' => 5,
                'title' => 'Manuka Soothing Drops with Lemon',
                'comment' => 'These drops taste great and they soothe my throat making me cough much less.',
                'is_verified_buyer' => true,
                'is_approved' => true,
                'order_reference' => 'ORD-2024-003',
                'reviewed_at' => now()->subDays(12)
            ],
            [
                'name' => 'Kevin',
                'email' => 'kevin@example.com',
                'location' => 'United States',
                'rating' => 5,
                'title' => 'Delicious and they really soothe my throat',
                'comment' => 'I absolutely love the soothing drops as well as your Manuka honey.',
                'is_verified_buyer' => false,
                'is_approved' => true,
                'reviewed_at' => now()->subDays(15)
            ],
            [
                'name' => 'Bonny S.',
                'email' => 'bonny@example.com',
                'location' => 'United States',
                'rating' => 5,
                'title' => 'Perfect for dry mouth',
                'comment' => 'I thought I would try these to help with dry mouth. I love the lemon flavor and they really do help!',
                'is_verified_buyer' => true,
                'is_approved' => true,
                'order_reference' => 'ORD-2024-004',
                'reviewed_at' => now()->subDays(18)
            ],
            [
                'name' => 'Sarah M.',
                'email' => 'sarah@example.com',
                'location' => 'Canada',
                'rating' => 4,
                'title' => 'Good quality product',
                'comment' => 'The product quality is excellent. The taste is very pleasant and natural. Would recommend to others looking for natural throat relief.',
                'is_verified_buyer' => true,
                'is_approved' => true,
                'order_reference' => 'ORD-2024-005',
                'reviewed_at' => now()->subDays(22)
            ],
            [
                'name' => 'John D.',
                'email' => 'john@example.com',
                'location' => 'United Kingdom',
                'rating' => 5,
                'title' => 'Amazing natural remedy',
                'comment' => 'These drops are fantastic! I use them whenever I feel a scratchy throat coming on. The manuka honey really makes a difference compared to regular throat drops.',
                'is_verified_buyer' => false,
                'is_approved' => true,
                'reviewed_at' => now()->subDays(25)
            ],
            [
                'name' => 'Emma W.',
                'email' => 'emma@example.com',
                'location' => 'Australia',
                'rating' => 4,
                'title' => 'Great for winter months',
                'comment' => 'Perfect for the cold season. I keep a pack in my purse and one at work. The lemon flavor is refreshing and not too sweet.',
                'is_verified_buyer' => true,
                'is_approved' => true,
                'order_reference' => 'ORD-2024-006',
                'reviewed_at' => now()->subDays(30)
            ],
            [
                'name' => 'David L.',
                'email' => 'david@example.com',
                'location' => 'New Zealand',
                'rating' => 5,
                'title' => 'Authentic Manuka honey taste',
                'comment' => 'You can really taste the quality of the manuka honey in these drops. Much better than synthetic alternatives. Great for singers and public speakers!',
                'is_verified_buyer' => true,
                'is_approved' => true,
                'order_reference' => 'ORD-2024-007',
                'reviewed_at' => now()->subDays(35)
            ],
            [
                'name' => 'Maria G.',
                'email' => 'maria@example.com',
                'location' => 'Germany',
                'rating' => 3,
                'title' => 'Good but expensive',
                'comment' => 'The drops work well and taste nice, but they are quite expensive compared to other options. Quality is good though.',
                'is_verified_buyer' => false,
                'is_approved' => false, // This one is pending approval
                'reviewed_at' => now()->subDays(2)
            ]
        ];

        foreach ($products->take(3) as $product) { // Add reviews to first 3 products
            foreach ($reviewData as $review) {
                // Add some variation to the reviews per product
                $reviewCopy = $review;
                $reviewCopy['product_id'] = $product->id;
                
                // Slightly modify some reviews for variety
                if ($product->id > 1) {
                    $reviewCopy['rating'] = max(1, $review['rating'] - rand(0, 1));
                }
                
                Review::create($reviewCopy);
            }
        }

        $this->command->info('Sample reviews created successfully!');
    }
}
