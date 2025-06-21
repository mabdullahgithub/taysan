<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Support\Str;
use App\Models\Category;

class CategorySeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run()
    {
        $categories = [
            ['name' => 'Men'],
            ['name' => 'Women'],
            ['name' => 'Kids'],
            ['name' => 'Accessories'],
         
        ];

        foreach ($categories as $category) {
            Category::create([
                'name' => $category['name'],
                // 'slug' => Str::slug($category['name']),
                // 'description' => $category['description'],
                // 'status' => $category['status'],
            ]);
        }
    }
}
