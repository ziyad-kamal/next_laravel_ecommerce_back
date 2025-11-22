<?php

namespace Database\Seeders;

use App\Models\{Cart, Item, User};
use Faker\Factory;
use Illuminate\Database\Seeder;

class CartSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $faker  = Factory::create();
        $users  = collect(User::pluck('id')->toArray());

        for ($i = 0; $i < 100; $i++) {
            $date   = $faker->dateTimeBetween('-5 years');

            $cart = Cart::create([
                'user_id'           => $users->random(),
                'created_at'        => $date,
                'updated_at'        => $date,
            ]);

            $items = Item::inRandomOrder()->take(3)->pluck('id')->toArray();
            $cart->items()->attach($items);
        }
    }
}
