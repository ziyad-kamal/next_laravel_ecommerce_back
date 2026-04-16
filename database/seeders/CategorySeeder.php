<?php

namespace Database\Seeders;

use App\Models\{Admin, Category};
use Faker\Factory;
use Illuminate\Database\Seeder;

class CategorySeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $faker       = Factory::create();
        $categories  = ['electronics', 'clothes', 'accessories'];
        $admins      = collect(Admin::pluck('id')->toArray());

        foreach ($categories as $category) {
            $date      = $faker->dateTimeBetween('-5 years');

            $category_id = Category::insertGetId([
                'name'                   => $category,
                'image'                  => 'image',
                'trans_lang'             => 'en',
                'admin_id'               => $admins->random(),
                'created_at'             => $date,
                'updated_at'             => $date,
            ]);

            Category::find($category_id)->update(['trans_of' => $category_id]);
        }
    }
}
