<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;

class DatabaseSeeder extends Seeder
{
    public function run(): void
    {
        $this->call([
            UserSeeder::class,
            OpeningHourSeeder::class,
            SettingSeeder::class,
            MenuSeeder::class,
            EventSeeder::class,
        ]);
    }
}
