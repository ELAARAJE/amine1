<?php

namespace Database\Seeders;

use App\Models\Dish;
use App\Models\MenuCategory;
use Illuminate\Database\Seeder;

class MenuSeeder extends Seeder
{
    public function run(): void
    {
        $menu = [
            [
                'name' => 'Entrées',
                'position' => 1,
                'dishes' => [
                    ['name' => 'Foie gras de canard maison', 'description' => 'Foie gras de canard mi-cuit, chutney de figues et brioche toastée.', 'price' => 18.00, 'allergens' => ['gluten', 'œufs']],
                    ['name' => 'Velouté de champignons des bois', 'description' => 'Velouté onctueux de cèpes et morilles, huile de truffe.', 'price' => 12.00, 'allergens' => ['lactose']],
                    ['name' => 'Tartare de saumon', 'description' => 'Saumon Label Rouge, avocat, citron vert et coriandre fraîche.', 'price' => 14.50, 'allergens' => ['poisson']],
                    ['name' => 'Salade de chèvre chaud', 'description' => 'Crottin de Chavignol rôti, mesclun, noix et vinaigrette au miel.', 'price' => 11.00, 'allergens' => ['lactose', 'fruits à coque']],
                ],
            ],
            [
                'name' => 'Plats',
                'position' => 2,
                'dishes' => [
                    ['name' => 'Filet de bœuf Rossini', 'description' => 'Filet de bœuf en croûte, escalope de foie gras poêlée, sauce Périgueux.', 'price' => 38.00, 'allergens' => ['gluten']],
                    ['name' => 'Sole meunière', 'description' => 'Sole de la Manche entière, beurre noisette, citron et persil plat.', 'price' => 32.00, 'allergens' => ['poisson', 'lactose']],
                    ['name' => 'Carré d\'agneau provençal', 'description' => 'Carré d\'agneau en persillade, légumes confits et jus aux herbes.', 'price' => 34.00, 'allergens' => ['gluten']],
                    ['name' => 'Risotto aux cèpes', 'description' => 'Risotto crémeux, cèpes sautés à l\'ail et au thym, copeaux de parmesan.', 'price' => 22.00, 'allergens' => ['lactose', 'gluten']],
                    ['name' => 'Saint-Jacques poêlées', 'description' => 'Noix de Saint-Jacques de la baie de Seine, purée de céleri et émulsion de crustacés.', 'price' => 29.00, 'allergens' => ['crustacés', 'lactose']],
                ],
            ],
            [
                'name' => 'Desserts',
                'position' => 3,
                'dishes' => [
                    ['name' => 'Fondant au chocolat Valrhona', 'description' => 'Cœur coulant au chocolat 66 %, glace à la vanille bourbon.', 'price' => 10.00, 'allergens' => ['gluten', 'œufs', 'lactose']],
                    ['name' => 'Crème brûlée à la vanille', 'description' => 'Crème brûlée traditionnelle à la gousse de vanille de Madagascar.', 'price' => 9.00, 'allergens' => ['œufs', 'lactose']],
                    ['name' => 'Tarte fine aux pommes', 'description' => 'Tarte fine caramélisée, glace caramel beurre salé.', 'price' => 9.50, 'allergens' => ['gluten', 'lactose', 'œufs']],
                    ['name' => 'Île flottante', 'description' => 'Blancs d\'œufs pochés, crème anglaise, caramel et amandes effilées.', 'price' => 8.50, 'allergens' => ['œufs', 'lactose', 'fruits à coque']],
                ],
            ],
            [
                'name' => 'Boissons',
                'position' => 4,
                'dishes' => [
                    ['name' => 'Eau minérale 75 cl', 'description' => 'Évian ou Badoit.', 'price' => 5.00, 'allergens' => []],
                    ['name' => 'Kir royal', 'description' => 'Crème de cassis de Dijon et Champagne brut.', 'price' => 12.00, 'allergens' => []],
                    ['name' => 'Café gourmand', 'description' => 'Espresso accompagné de trois mignardises du jour.', 'price' => 8.00, 'allergens' => ['lactose', 'gluten', 'œufs']],
                ],
            ],
        ];

        foreach ($menu as $position => $categoryData) {
            $category = MenuCategory::create([
                'name' => $categoryData['name'],
                'position' => $categoryData['position'],
                'is_visible' => true,
            ]);

            foreach ($categoryData['dishes'] as $dishPosition => $dishData) {
                Dish::create([
                    'menu_category_id' => $category->id,
                    'name' => $dishData['name'],
                    'description' => $dishData['description'],
                    'price' => $dishData['price'],
                    'allergens' => $dishData['allergens'],
                    'position' => $dishPosition + 1,
                    'is_visible' => true,
                ]);
            }
        }
    }
}
