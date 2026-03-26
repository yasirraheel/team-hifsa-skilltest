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
        $this->call([
            FaqSeeder::class,
            TestimonialSeeder::class,
            WorksSeeder::class,
            BannerSeeder::class,
            AdvertisementSeeder::class,
            ExploreCategoriesSeeder::class,
            BlogSeeder::class,
            SeoSeeder::class,
        ]);
    }
}
