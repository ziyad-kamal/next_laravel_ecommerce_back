<?php

namespace Database\Seeders;

use App\Models\{Item, Item_info, Order, Order_item, User};
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
        $usersIds    = collect(User::pluck('id')->toArray());

        // Create 50 orders instead of one per item
        for ($i = 0; $i < 100; $i++) {
            $date     = $faker->dateTimeBetween('-5 years');
            $quantity = $faker->numberBetween(1, 3);

            $randomItemIds = Item::inRandomOrder()->take(3)->pluck('id')->toArray();

            // Calculate total amount from all items
            $totalAmount = 0;
            foreach ($randomItemIds as $id) {
                $price = Item_info::where('item_id', $id)->value('price');
                $totalAmount += $price * $quantity;
            }

            $order = Order::create([
                'total_amount'         => $totalAmount,
                'state'                => 4,
                'method'               => $faker->numberBetween(1, 2),
                'user_id'              => $usersIds->random(),
                'date_of_delivery'     => (clone $date)->modify('+3 days'),
                'created_at'           => $date,
                'updated_at'           => $date,
            ]);

            $order->items()->attach($randomItemIds);
            Order_item::where('order_id', $order->id)->update(['quantity' => $quantity]);
        }
    }
}
