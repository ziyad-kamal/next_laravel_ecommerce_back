<?php

namespace Database\Seeders;

use App\Models\{Item, Order, User};
use Faker\Factory;
use Illuminate\Database\Seeder;

class OrderSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $faker       = Factory::create();
        $itemsId     = Item::pluck('id')->toArray();
        $usersIds    = collect(User::pluck('id')->toArray());

        foreach ($itemsId as $itemId) {
            $date  = $faker->dateTimeBetween('-5 years');

            $order = Order::create([
                'bank_trans_id' => $faker->numberBetween(5000000, 6000000),
                'total_amount'  => $faker->numberBetween(500, 6000),
                'quantity'      => $faker->numberBetween(1, 3),
                'state'         => $faker->numberBetween(1, 5),
                'user_id'       => $usersIds->random(),
                'created_at'    => $date,
                'updated_at'    => $date,
            ]);

            $items = Item::inRandomOrder()->take(3)->pluck('id')->toArray();
            $order->items()->attach($items);
        }
    }
}
