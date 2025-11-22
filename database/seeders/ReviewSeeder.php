<?php

namespace Database\Seeders;

use App\Models\{Item, Review, User};
use Faker\Factory;
use Illuminate\Database\Seeder;

class ReviewSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $faker       = Factory::create();
        $itemsId     = collect(Item::pluck('id')->toArray());
        $usersIds    = collect(User::pluck('id')->toArray());

        foreach ($itemsId as $itemId) {
            $date      = $faker->dateTimeBetween('-5 years');

            Review::insert([
                'rate'          => $faker->numberBetween(1, 5),
                'content'       => $faker->sentence(),
                'user_id'       => $usersIds->random(),
                'item_id'       => $itemsId->random(),
                'created_at'    => $date,
                'updated_at'    => $date,
            ]);
        }
    }
}
