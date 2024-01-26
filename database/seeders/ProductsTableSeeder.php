<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;
use Faker\Factory as Faker;

class ProductsTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        $faker = Faker::create();

        // Get existing user and category IDs
        $userIds = DB::table('users')->pluck('id')->toArray();
        $categoryIds = DB::table('categories')->pluck('id')->toArray();

        // Adjust the number to control the amount of fake data
        $numberOfProducts = 20; // You can adjust this based on your needs

        for ($i = 0; $i < $numberOfProducts; $i++) {
            DB::table('products')->insert([
                'user_id' => $faker->randomElement($userIds),
                'category_id' => $faker->randomElement($categoryIds),
                'name' => $faker->words(3, true),
                'price' => $faker->randomFloat(2, 10, 1000),
                'unit' => $faker->randomElement(['piece', 'kg', 'liter']),
                'img_url' => $faker->imageUrl(),
            ]);
        }
    }
}
