<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class ProductSeed extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        // DB::table('categories')->truncate();
        DB::table('products')->insert([
            ['name' => 'tivi', 'image' => './public/images/electronics.jpg', 'price' => 12000, 'status' => true,  'created_at' => now(), 'updated_at' => now(), 'category_id' => 1],
            ['name' => 'iphone', 'image' => './public/images/electronics.jpg', 'price' => 1009077, 'status' => true,  'created_at' => now(), 'updated_at' => now(), 'category_id' => 3],
            ['name' => 'bom nguyên tử', 'image' => './public/images/electronics.jpg', 'price' => 10000, 'status' => false,  'created_at' => now(), 'updated_at' => now(), 'category_id' => 4],
            ['name' => 'bom hạt nhân', 'image' => './public/images/electronics.jpg', 'price' => 10000, 'status' => false,  'created_at' => now(), 'updated_at' => now(), 'category_id' => 2],
            ['name' => 'xe', 'image' => './public/images/electronics.jpg', 'price' => 10000900, 'status' => true,  'created_at' => now(), 'updated_at' => now(), 'category_id' => 3],
        ]);
    }
}
