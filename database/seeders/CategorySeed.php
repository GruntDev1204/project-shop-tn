<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class CategorySeed extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        // DB::table('categories')->delete();
        // DB::table('categories')->truncate();

        DB::table('categories')->insert([
            ['name' => 'Electronics', 'created_at' => now(), 'updated_at' => now()],
            ['name' => 'Fashion', 'created_at' => now(), 'updated_at' => now()],
            ['name' => 'Home Appliances', 'created_at' => now(), 'updated_at' => now()],
            ['name' => 'Books', 'created_at' => now(), 'updated_at' => now()],
            ['name' => 'Toys', 'created_at' => now(), 'updated_at' => now()],
        ]);
    }
}
