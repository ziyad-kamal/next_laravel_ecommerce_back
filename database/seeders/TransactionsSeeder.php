<?php

namespace Database\Seeders;

use App\Models\{Item, Order, Transaction};
use Faker\Factory;
use Illuminate\Database\Seeder;

class TransactionsSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $faker        = Factory::create();
        $itemsId      = Item::pluck('id')->toArray();
        $ordersIds    = collect(Order::pluck('id')->toArray());

        foreach ($itemsId as $itemId) {
            $date     = $faker->dateTimeBetween('-5 years');

            Transaction::create([
                'bank_trans_id'   => $faker->numberBetween(5000000, 6000000),
                'type'            => $faker->numberBetween(1, 2),
                'order_id'        => $ordersIds->random(),
                'created_at'      => $date,
            ]);
        }
    }
}
