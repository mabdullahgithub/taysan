<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class ProductSeeders extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $products = [
            [
                'category_id' => 2,
                'name' => 'Blue And White Cape Shawl',
                'description' => 'Elegant blue and white cape shawl for women.',
                'price' => 250.00,
                'stock' => 10,
                'image' => 'products/iXYZv1d23sa5qj391nuLL9h2dVR94V5bdZx0s3rG.png',
                'status' => true,
            ],
            [
                'category_id' => 3,
                'name' => 'Red Dress',
                'description' => 'Stylish red dress for women.',
                'price' => 150.00,
                'stock' => 15,
                'image' => 'products/bjStDbMOIDWR3QouoYx3Q0foOBZTEz1GBj4Kv3N4.jpg',
                'status' => true,
            ],
            [
                'category_id' => 4,
                'name' => 'Green Scarf',
                'description' => 'Beautiful green scarf for all occasions.',
                'price' => 50.00,
                'stock' => 20,
                'image' => 'products/iXYZv1d23sa5qj391nuLL9h2dVR94V5bdZx0s3rG.png',
                'status' => true,
            ],
            [
                'category_id' => 2,
                'name' => 'Black Hat',
                'description' => 'Classic black hat for men and women.',
                'price' => 75.00,
                'stock' => 30,
                'image' => 'products/xmuPNsfe5i2s6ApQRHKG4wpGvGCWMPt6YSe7eKzD.png',
                'status' => true,
            ],
            [
                'category_id' => 3,
                'name' => 'Yellow T-Shirt',
                'description' => 'Bright yellow t-shirt for casual wear.',
                'price' => 25.00,
                'stock' => 50,
                'image' => 'products/iXYZv1d23sa5qj391nuLL9h2dVR94V5bdZx0s3rG.png',
                'status' => true,
            ],
            [
                'category_id' => 4,
                'name' => 'Blue Jeans',
                'description' => 'Comfortable blue jeans for everyday use.',
                'price' => 100.00,
                'stock' => 40,
                'image' => 'products/xmuPNsfe5i2s6ApQRHKG4wpGvGCWMPt6YSe7eKzD.png',
                'status' => true,
            ],
            [
                'category_id' => 2,
                'name' => 'White Sneakers',
                'description' => 'Stylish white sneakers for all ages.',
                'price' => 120.00,
                'stock' => 25,
                'image' => 'products/iXYZv1d23sa5qj391nuLL9h2dVR94V5bdZx0s3rG.png',
                'status' => true,
            ],
            [
                'category_id' => 3,
                'name' => 'Purple Jacket',
                'description' => 'Warm purple jacket for winter.',
                'price' => 200.00,
                'stock' => 15,
                'image' => 'products/xmuPNsfe5i2s6ApQRHKG4wpGvGCWMPt6YSe7eKzD.png',
                'status' => true,
            ],
            [
                'category_id' => 4,
                'name' => 'Orange Sunglasses',
                'description' => 'Trendy orange sunglasses for summer.',
                'price' => 80.00,
                'stock' => 35,
                'image' => 'products/iXYZv1d23sa5qj391nuLL9h2dVR94V5bdZx0s3rG.png',
                'status' => true,
            ],
            [
                'category_id' => 2,
                'name' => 'Pink Handbag',
                'description' => 'Chic pink handbag for women.',
                'price' => 180.00,
                'stock' => 20,
                'image' => 'products/bjStDbMOIDWR3QouoYx3Q0foOBZTEz1GBj4Kv3N4.jpg',
                'status' => true,
            ],
        ];

        DB::table('products')->insert($products);
    }
}
