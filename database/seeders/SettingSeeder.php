<?php

namespace Database\Seeders;

use App\Models\Setting;
use Illuminate\Database\Seeder;

class SettingSeeder extends Seeder
{
    public function run(): void
    {
        $defaults = [
            'capacity'          => '40',  // max couverts simultanés
            'slot_interval'     => '30',  // minutes entre deux créneaux
            'meal_duration'     => '120', // durée moyenne d'un repas (minutes)
            'min_advance_hours' => '2',   // délai minimum de réservation (heures)
            'max_guests'        => '10',  // max couverts par réservation
        ];

        foreach ($defaults as $key => $value) {
            Setting::firstOrCreate(['key' => $key], ['value' => $value]);
        }
    }
}
