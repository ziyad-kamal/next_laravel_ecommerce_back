<?php

namespace Database\Seeders;

use App\Models\{Vendor, Vendor_info};
use Faker\Factory;
use Illuminate\Database\Seeder;

class VendorInfoSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $faker          = Factory::create();
        $vendorsIds     = Vendor::pluck('id')->toArray();

        foreach ($vendorsIds as $vendorId) {
            $date      = $faker->dateTimeBetween('-5 years');

            Vendor_info::insert([
                'address'               => $faker->address(),
                'phone'                 => $faker->numberBetween(1000000, 6000000),
                'card_num'              => encrypt($faker->creditCardNumber()),
                'card_type'             => $faker->creditCardType(),
                'csv'                   => encrypt($faker->numberBetween(100, 900)),
                'card_exp_date'         => encrypt($faker->creditCardExpirationDate()),
                'card_name'             => encrypt($faker->name()),
                'vendor_id'             => $vendorId,
                'created_at'            => $date,
                'updated_at'            => $date,
            ]);
        }
    }
}
