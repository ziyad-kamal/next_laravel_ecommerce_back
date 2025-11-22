<?php

namespace Database\Seeders;

use App\Models\{User, User_info};
use Faker\Factory;
use Illuminate\Database\Seeder;

class UserInfoSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $faker        = Factory::create();
        $usersIds     = User::pluck('id')->toArray();

        foreach ($usersIds as $userId) {
            $date      = $faker->dateTimeBetween('-5 years');

            User_info::insert([
                'address'             => $faker->address(),
                'phone'               => $faker->numberBetween(1000000, 6000000), // 10-digit numeric phone number
                'card_num'            => encrypt($faker->creditCardNumber()),
                'card_type'           => $faker->creditCardType(),
                'csv'                 => encrypt($faker->numberBetween(100, 900)),
                'card_exp_date'       => encrypt($faker->creditCardExpirationDate()),
                'card_name'           => encrypt($faker->name()),
                'user_id'             => $userId,
                'created_at'          => $date,
                'updated_at'          => $date,
            ]);
        }
    }
}
