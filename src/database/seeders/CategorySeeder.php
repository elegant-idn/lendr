<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Str;

class CategorySeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run()
    {
        $categories = [
            ['name' => 'Camera & Gear', 'slug' => Str::slug('Camera & Gear', '-'), 'is_available' => 1, 'is_deleted' => 2, 'image' => 'category-camera-gear.png'],
            ['name' => 'Moving Gear', 'slug' => Str::slug('Moving Gear', '-'), 'is_available' => 1, 'is_deleted' => 2, 'image' => 'category-moving-gear.png'],
            ['name' => 'Electronics', 'slug' => Str::slug('Electronics', '-'), 'is_available' => 1, 'is_deleted' => 2, 'image' => 'category-electronics.png'],
            ['name' => 'Clothing', 'slug' => Str::slug('Clothing', '-'), 'is_available' => 1, 'is_deleted' => 2, 'image' => 'category-clothing.png'],
            ['name' => 'Tools & Hardware', 'slug' => Str::slug('Tools & Hardware', '-'), 'is_available' => 1, 'is_deleted' => 2, 'image' => 'category-tools-hardware.png'],
            ['name' => 'Events & Parties', 'slug' => Str::slug('Events & Parties', '-'), 'is_available' => 1, 'is_deleted' => 2, 'image' => 'category-events-parties.png'],
            ['name' => 'Furniture', 'slug' => Str::slug('Furniture', '-'), 'is_available' => 1, 'is_deleted' => 2, 'image' => 'category-furniture.png'],
            ['name' => 'Jewerly', 'slug' => Str::slug('Jewerly', '-'), 'is_available' => 1, 'is_deleted' => 2, 'image' => 'category-jewerly.png'],
            ['name' => 'Sporting Goods', 'slug' => Str::slug('Sporting Goods', '-'), 'is_available' => 1, 'is_deleted' => 2, 'image' => 'category-sporting-goods.png'],
            ['name' => 'Textbooks', 'slug' => Str::slug('Textbooks', '-'), 'is_available' => 1, 'is_deleted' => 2, 'image' => 'category-textbooks.png'],
            ['name' => 'Shoes', 'slug' => Str::slug('Shoes', '-'), 'is_available' => 1, 'is_deleted' => 2, 'image' => 'category-shoes.png'],
        ];

        foreach ($categories as $category) {
            $checkSlug = DB::table('categories')->where('slug', $category['slug'])->first();

            if (!empty($checkSlug)) {
                $lastId = DB::table('categories')->select('id')->orderByDesc('id')->first();
                $category['slug'] = Str::slug($category['name'] . ' ' . $lastId->id, '-');
            }
            $now = now();
            $category['created_at'] = $now;
            $category['updated_at'] = $now;

            DB::table('categories')->insert($category);
        }
    }
}
