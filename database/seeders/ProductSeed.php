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
            ['name' => 'tivi', 'image' => './public/images/electronics.jpg', 'price' => 12000, 'status' => true, 'discount' => 0, 'description' => 'Tivi thì để xem thôi chứ làm gì?', 'created_at' => now(), 'updated_at' => now(), 'category_id' => 1, 'origin' => 'Việt Nam', 'quantity' => 100],
            ['name' => 'iphone', 'image' => './public/images/electronics.jpg', 'price' => 1009077, 'status' => true, 'discount' => 0, 'description' => 'Chiếc điện thoại mơ ước của hội nhà giàu.', 'created_at' => now(), 'updated_at' => now(), 'category_id' => 3, 'origin' => 'TQ', 'quantity' => 100],
            ['name' => 'bom nguyên tử', 'image' => './public/images/electronics.jpg', 'price' => 10000, 'status' => false, 'discount' => 0, 'description' => 'Sản phẩm này không được bán trên thị trường 🤫.', 'created_at' => now(), 'updated_at' => now(), 'category_id' => 4, 'origin' => 'Mỹ', 'quantity' => 100],
            ['name' => 'bom hạt nhân', 'image' => './public/images/electronics.jpg', 'price' => 10000, 'status' => false, 'discount' => 0, 'description' => 'Cùng họ với bom nguyên tử nhưng nâng cấp hơn!', 'created_at' => now(), 'updated_at' => now(), 'category_id' => 2, 'origin' => 'Taiwan', 'quantity' => 100],
            ['name' => 'xe', 'image' => './public/images/electronics.jpg', 'price' => 10000900, 'status' => true, 'discount' => 0, 'description' => 'Xe dùng để đi chứ làm gì nữa?', 'created_at' => now(), 'updated_at' => now(), 'category_id' => 3, 'origin' => 'Việt Nam', 'quantity' => 100],
        ]);
    }
}
