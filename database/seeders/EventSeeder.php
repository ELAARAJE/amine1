<?php

namespace Database\Seeders;

use App\Models\Event;
use Illuminate\Database\Seeder;
use Illuminate\Support\Str;

class EventSeeder extends Seeder
{
    public function run(): void
    {
        $events = [
            [
                'title' => 'Soirée Beaujolais Nouveau',
                'description' => 'Rejoignez-nous le troisième jeudi de novembre pour célébrer l\'arrivée du Beaujolais Nouveau. Dîner en accord mets et vins avec sélection de cinq cuvées, animé par notre sommelier. Menu spécial en six temps.',
                'starts_at' => '2026-11-19 19:30:00',
                'price' => 75.00,
                'is_published' => true,
            ],
            [
                'title' => 'Menu Saint-Valentin',
                'description' => 'Offrez à votre partenaire une soirée inoubliable autour d\'un menu gastronomique en quatre services, champagne de bienvenue et mise en scène florale. Réservation indispensable.',
                'starts_at' => '2027-02-14 19:00:00',
                'price' => 95.00,
                'is_published' => true,
            ],
            [
                'title' => 'Atelier Accords Vins & Fromages',
                'description' => 'Découvrez l\'art des accords entre vins régionaux et fromages artisanaux lors de cet atelier convivial animé par notre chef sommelier. Dégustation de six accords commentés.',
                'starts_at' => '2026-10-15 18:30:00',
                'price' => 55.00,
                'is_published' => true,
            ],
            [
                'title' => 'Dîner de Noël',
                'description' => 'Passez les fêtes de fin d\'année au Birlik autour d\'un menu de Noël élaboré par notre chef. Foie gras, turbot de ligne, bûche maison... Un moment d\'exception en famille ou entre amis.',
                'starts_at' => '2026-12-24 19:30:00',
                'price' => 110.00,
                'is_published' => true,
            ],
            [
                'title' => 'Brunch Dominical',
                'description' => 'Chaque premier dimanche du mois, Le Birlik vous accueille pour un brunch généreux : viennoiseries maison, œufs à toutes les façons, charcuteries, fromages et douceurs sucrées. Réservation conseillée.',
                'starts_at' => '2026-10-04 11:00:00',
                'price' => 38.00,
                'is_published' => true,
            ],
        ];

        foreach ($events as $eventData) {
            Event::create([
                'title' => $eventData['title'],
                'slug' => Str::slug($eventData['title']),
                'description' => $eventData['description'],
                'starts_at' => $eventData['starts_at'],
                'price' => $eventData['price'],
                'is_published' => $eventData['is_published'],
                'image' => null,
            ]);
        }
    }
}
