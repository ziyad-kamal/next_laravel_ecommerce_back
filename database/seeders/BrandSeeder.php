<?php

namespace Database\Seeders;

use App\Models\{Admin, Brand};
use Faker\Factory;
use Illuminate\Database\Seeder;

class BrandSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $faker  = Factory::create();
        $admins = collect(Admin::pluck('id')->toArray());
        $brand  = collect(['apple', 'hp', 'dell']);

        for ($i = 0; $i < 100; $i++) {
            $date   = $faker->dateTimeBetween('-5 years');

            $brand_id = Brand::insertGetId([
                'name'              => $brand->random(),
                'trans'             => 'en',
                'admin_id'          => $admins->random(),
                'created_at'        => $date,
                'updated_at'        => $date,
            ]);

            Brand::find($brand_id)->update(['trans_of' => $brand_id]);
        }
    }
}
