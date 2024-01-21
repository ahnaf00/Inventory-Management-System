<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;
use Faker\Factory as Faker;
class CustomersTableSeeder extends Seeder
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
        // Insert demo data into the 'customers' table


        $numberOfCategories = 10;

        for ($i = 0; $i < $numberOfCategories; $i++) {
            DB::table('customers')->insert([
                'name' =>  $faker->name,
                'email' => $faker->email,
                'mobile' => $faker->phoneNumber,
                'user_id' => $faker->randomElement($userIds) // Replace with an existing user_id
            ]);
        }

    }
}
