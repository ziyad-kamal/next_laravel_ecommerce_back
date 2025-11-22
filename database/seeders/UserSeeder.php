<?php

namespace Database\Seeders;

use App\Models\{User};
use Faker\Factory;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\Hash;

class UserSeeder extends Seeder
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

            User::insert([
                'name'               => $name,
                'email'              => $faker->unique()->safeEmail(),
                'password'           => Hash::make('13131313'),
                'active'             => $faker->randomElement(['active', 'inactive']), // Fix: get value, not key
                'email_verified_at'  => $faker->dateTimeBetween('-5 years'), // Fix: use datetime
                'created_at'         => $date,
                'updated_at'         => $date,
            ]);
        }
    }
}
