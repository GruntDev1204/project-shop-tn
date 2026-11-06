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
            ['name' => 'tivi 100000000000000000 inch Pandasonic', 'image' => './public/images/electronics.jpg', 'price' => 12000, 'status' => true, 'discount' => 0, 'description' => 'Tivi thì để xem thôi chứ làm gì?', 'created_at' => now(), 'updated_at' => now(), 'category_id' => 1, 'origin' => 'Việt Nam', 'quantity' => 100],
            ['name' => 'iphone -700TCN plus', 'image' => './public/images/electronics.jpg', 'price' => 1009077, 'status' => true, 'discount' => 0, 'description' => 'Chiếc điện thoại mơ ước của hội nhà giàu.', 'created_at' => now(), 'updated_at' => now(), 'category_id' => 3, 'origin' => 'TQ', 'quantity' => 100],
            ['name' => 'bom nguyên tử Yamaha', 'image' => './public/images/electronics.jpg', 'price' => 10000, 'status' => false, 'discount' => 0, 'description' => 'Sản phẩm này đã có giải Nobel hòa bình.', 'created_at' => now(), 'updated_at' => now(), 'category_id' => 4, 'origin' => 'Mỹ', 'quantity' => 100],
            ['name' => 'bom nhiệt hạch Asus', 'image' => './public/images/electronics.jpg', 'price' => 10000, 'status' => false, 'discount' => 0, 'description' => 'Cùng họ với bom nguyên tử nhưng nâng cấp hơn!', 'created_at' => now(), 'updated_at' => now(), 'category_id' => 2, 'origin' => 'Taiwan', 'quantity' => 100],
            ['name' => 'xe tank Rolex rep 1:10000000', 'image' => './public/images/electronics.jpg', 'price' => 10000900, 'status' => true, 'discount' => 0, 'description' => 'Xe dùng để đi chứ làm gì nữa?', 'created_at' => now(), 'updated_at' => now(), 'category_id' => 3, 'origin' => 'Việt Nam', 'quantity' => 100],
            ['name' => 'Bánh trung thu nhân Uranium nguyên bản siêu ngon', 'image' => './public/images/cake.jpg', 'price' => 10000900, 'status' => true, 'discount' => 0, 'description' => 'Bánh thì dùng để ăn chứ làm gì nữa?', 'created_at' => now(), 'updated_at' => now(), 'category_id' => 3, 'origin' => 'Việt Nam', 'quantity' => 100],
            ['name' => 'ống nhòm hãng KFC chính hãng , zoom lên đến 0.002nm', 'image' => './public/images/glass.jpg', 'price' => 10000900, 'status' => true, 'discount' => 0, 'description' => 'Dùng nhòm chứ làm gì nữa?', 'created_at' => now(), 'updated_at' => now(), 'category_id' => 3, 'origin' => 'Việt Nam', 'quantity' => 100],
            ['name' => 'Xô Dung nham 700000000 độ C dung tích 7000km3, đồ chơi sáng tạo thân thiện cho trẻ em', 'image' => './public/images/fire.jpg', 'price' => 10000900, 'status' => true, 'discount' => 0, 'description' => 'Dùng để chơi chứ làm gì nữa?', 'created_at' => now(), 'updated_at' => now(), 'category_id' => 3, 'origin' => 'Việt Nam', 'quantity' => 100],
            ['name' => 'Khiên Vibranium 30000x30000 chính hãng Honda dùng để che mưa', 'image' => './public/images/sheild.jpg', 'price' => 10000900, 'status' => true, 'discount' => 0, 'description' => 'Dùng để đội chứ làm gì nữa?', 'created_at' => now(), 'updated_at' => now(), 'category_id' => 3, 'origin' => 'Việt Nam', 'quantity' => 100],
            ['name' => 'Ma túy đá thực phẩm chức năng chắc khỏe xương chính hãng Suzuki', 'image' => './public/images/any.jpg', 'price' => 10000900, 'status' => true, 'discount' => 0, 'description' => 'Dùng để đốt lên hít chứ làm gì nữa?', 'created_at' => now(), 'updated_at' => now(), 'category_id' => 3, 'origin' => 'Campuchia', 'quantity' => 1100],
        ]);
    }
}
