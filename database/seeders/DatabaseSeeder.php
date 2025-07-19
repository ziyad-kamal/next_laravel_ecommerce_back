<?php

namespace Database\Seeders;

// use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class DatabaseSeeder extends Seeder
{
    /**
     * Seed the application's database.
     */
    public function run(): void
    {
        // $this->call(AdminSeeder::class);
        // $this->call(UserSeeder::class);
        // $this->call(UserInfoSeeder::class);
        // $this->call(VendorSeeder::class);
        // $this->call(VendorInfoSeeder::class);
        // $this->call(CategorySeeder::class);
        // $this->call(BrandSeeder::class);
        // $this->call(ItemSeeder::class);
        // $this->call(ItemInfoSeeder::class);
        // $this->call(OrderSeeder::class);
        // $this->call(CartSeeder::class);
        $this->call(ReviewSeeder::class);
    }
}
