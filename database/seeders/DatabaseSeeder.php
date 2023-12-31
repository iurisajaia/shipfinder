<?php

namespace Database\Seeders;

// use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class DatabaseSeeder extends Seeder
{
    /**
     * Seed the application's database.
     *
     * @return void
     */
    public function run()
    {
        $this->call([
            UserRoleSeeder::class,
            LanguageSeeder::class,
            CarBodyTypeSeeder::class,
            CarLoadingTypeSeeder::class,
            TrailerTypeSeeder::class,
            PaymentMethodSeeder::class,
            CountrySeeder::class,
            PackageTypeSeeder::class,
            DangerStatusSeeder::class
        ]);
    }
}
