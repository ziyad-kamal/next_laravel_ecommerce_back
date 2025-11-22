<?php

namespace Database\Seeders;

use App\Models\{Admin, Brand, Category, Item};
use Faker\Factory;
use Illuminate\Database\Seeder;
use Illuminate\Support\Str;

class ItemSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $faker       = Factory::create();
        $adminIds    = collect(Admin::pluck('id')->toArray());
        $categoryIds = collect(Category::pluck('id')->toArray());
        $brandIds    = collect(Brand::pluck('id')->toArray());

        for ($i = 0; $i < 100; $i++) {
            $date      = $faker->dateTimeBetween('-5 years');
            $name      = $faker->name();

            $itemId = Item::insertGetId([
                'name'               => $name,
                'slug'               => Str::slug($name.'-'.$i),
                'approve'            => $faker->randomElement(['approved', 'pending', 'refused']),
                'trans_lang'         => 'en',
                'admin_id'           => $adminIds->random(),
                'category_id'        => $categoryIds->random(),
                'brand_id'           => $brandIds->random(),
                'created_at'         => $date,
                'updated_at'         => $date,
            ]);

            Item::find($itemId)->update(['trans_of' => $itemId]);
        }
    }
}
