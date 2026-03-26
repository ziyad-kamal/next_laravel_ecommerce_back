<?php

namespace Database\Seeders;

use App\Models\Admin;
use Faker\Factory;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\Hash;

class AdminSeeder extends Seeder
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

            Admin::insert([
                'name'                => $name,
                'email'               => $faker->unique()->safeEmail(),
                'bio'                 => $faker->paragraph(),
                'address'             => $faker->address(),
                'phone'               => $faker->numberBetween(100000000, 300000000),
                'password'            => Hash::make('13131313'),
                'created_at'          => $date,
                'updated_at'          => $date,
            ]);
        }
    }
}
