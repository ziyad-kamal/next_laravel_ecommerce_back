<?php

namespace Database\Seeders;

use App\Models\{Vendor};
use Faker\Factory;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\Hash;

class VendorSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $faker = Factory::create();

        for ($i = 0; $i < 100; $i++) {
            $date   = $faker->dateTimeBetween('-5 years');
            $name   = $faker->name();

            Vendor::insert([
                'name'               => $name,
                'email'              => $faker->unique()->safeEmail(),
                'password'           => Hash::make('13131313'),
                'active'             => $faker->randomElement(['active', 'inactive']),
                'email_verified_at'  => $date,
                'created_at'         => $date,
                'updated_at'         => $date,
            ]);
        }
    }
}
