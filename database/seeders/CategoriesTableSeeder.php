<?php

namespace Database\Seeders;

use App\Models\Category;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class CategoriesTableSeeder extends Seeder
{
    /**
     * Führt den Datenbank Seeder aus.
     */
    public function run(): void
    {
        // https://www.editeur.org/files/Thema/1.6/v1.6_de/20250204_Thema_v1.6_de.html
        $categories = [
            [
                'code' => 0,
                'name' => 'Keine Kategorie',
                'description' => 'Keine Kategorie',
            ],
            [
                'code' => 'FH',
                'name' => 'Historischer Roman',
                'description' => 'Romane mit historischem Setting',
            ],
            [
                'code' => 'FJH',
                'name' => 'Science-Fiction',
                'description' => 'Romane mit futuristischen oder alternativen Realitäten',
            ],
            [
                'code' => 'FA',
                'name' => 'Belletristik',
                'description' => 'Allgemeine erzählende Literatur',
            ],
            [
                'code' => 'FM',
                'name' => 'Krimi & Thriller',
                'description' => 'Spannende Geschichten mit kriminalistischen Elementen',
            ],
            [
                'code' => 'YFB',
                'name' => 'Kinderbücher',
                'description' => 'Bücher für Kinder und Jugendliche',
            ],
            [
                'code' => 'XQB',
                'name' => 'Manga',
                'description' => 'Japanische Comics und Graphic Novels',
            ],
        ];

        foreach ($categories as $category) {
            Category::create($category);
        }
    }
}
