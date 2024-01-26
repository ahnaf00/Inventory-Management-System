<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;
use Faker\Factory as Faker;

class CategoriesTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        $faker = Faker::create();

        // Get existing user IDs
        $userIds = DB::table('users')->pluck('id')->toArray();

        // Adjust the number to control the amount of fake data
        $numberOfCategories = 10;

        for ($i = 0; $i < $numberOfCategories; $i++) {
            DB::table('categories')->insert([
                'name' => $faker->name,
                'user_id' => $faker->randomElement($userIds),
            ]);
        }
    }
}
