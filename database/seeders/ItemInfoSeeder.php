<?php

namespace Database\Seeders;

use App\Models\{Item, Item_info};
use Faker\Factory;
use Illuminate\Database\Seeder;

class ItemInfoSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $faker   = Factory::create();
        $itemsId = Item::pluck('id')->toArray();

        foreach ($itemsId as $itemId) {
            $date      = $faker->dateTimeBetween('-5 years');

            $itemInfoId = Item_info::insertGetId([
                'description'            => $faker->sentence(),
                'condition'              => $faker->randomElement(['new', 'used']),
                'price'                  => $faker->numberBetween(100, 5000),
                'trans_lang'             => 'en',
                'item_id'                => $itemId,
                'created_at'             => $date,
                'updated_at'             => $date,
            ]);

            Item_info::find($itemInfoId)->update(['trans_of' => $itemInfoId]);
        }
    }
}
