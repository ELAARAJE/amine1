<?php

namespace Database\Seeders;

use App\Models\OpeningHour;
use Illuminate\Database\Seeder;

class OpeningHourSeeder extends Seeder
{
    public function run(): void
    {
        OpeningHour::truncate();

        // Days: 0=Sunday, 1=Monday, 2=Tuesday, 3=Wednesday, 4=Thursday, 5=Friday, 6=Saturday
        $schedule = [
            // Monday: closed all day
            ['day_of_week' => 1, 'service' => 'lunch',  'start_time' => '12:00', 'end_time' => '14:30', 'is_open' => false],
            ['day_of_week' => 1, 'service' => 'dinner', 'start_time' => '19:00', 'end_time' => '22:30', 'is_open' => false],
            // Tuesday–Saturday: open lunch + dinner
            ['day_of_week' => 2, 'service' => 'lunch',  'start_time' => '12:00', 'end_time' => '14:30', 'is_open' => true],
            ['day_of_week' => 2, 'service' => 'dinner', 'start_time' => '19:00', 'end_time' => '22:30', 'is_open' => true],
            ['day_of_week' => 3, 'service' => 'lunch',  'start_time' => '12:00', 'end_time' => '14:30', 'is_open' => true],
            ['day_of_week' => 3, 'service' => 'dinner', 'start_time' => '19:00', 'end_time' => '22:30', 'is_open' => true],
            ['day_of_week' => 4, 'service' => 'lunch',  'start_time' => '12:00', 'end_time' => '14:30', 'is_open' => true],
            ['day_of_week' => 4, 'service' => 'dinner', 'start_time' => '19:00', 'end_time' => '22:30', 'is_open' => true],
            ['day_of_week' => 5, 'service' => 'lunch',  'start_time' => '12:00', 'end_time' => '14:30', 'is_open' => true],
            ['day_of_week' => 5, 'service' => 'dinner', 'start_time' => '19:00', 'end_time' => '23:00', 'is_open' => true],
            ['day_of_week' => 6, 'service' => 'lunch',  'start_time' => '12:00', 'end_time' => '14:30', 'is_open' => true],
            ['day_of_week' => 6, 'service' => 'dinner', 'start_time' => '19:00', 'end_time' => '23:00', 'is_open' => true],
            // Sunday: lunch only, closed for dinner
            ['day_of_week' => 0, 'service' => 'lunch',  'start_time' => '12:00', 'end_time' => '14:30', 'is_open' => true],
            ['day_of_week' => 0, 'service' => 'dinner', 'start_time' => '19:00', 'end_time' => '22:30', 'is_open' => false],
        ];

        foreach ($schedule as $row) {
            OpeningHour::create($row);
        }
    }
}
