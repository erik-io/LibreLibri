<?php

namespace Database\Seeders;

use App\Models\Category;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\File;

class CategoriesTableSeeder extends Seeder
{
    /**
     * Führt den Datenbank Seeder aus.
     *
     * Diese Methode fügt eine Liste von Kategorien in die `categories`-Tabelle ein.
     * Die Codes entsprechen dem EDItEUR Thema 1.6 Standard.
     * Quelle: https://www.editeur.org/151/Thema
     */
    public function run(): void
    {
        // Pfad zur Datei mit den Kategorien
        $jsonPath = database_path('data/20250204_Thema_v1.6_de.json');

        // Lesen der JSON-Datei
        $jsonData = File::get($jsonPath);
        $categories = json_decode($jsonData, true);

        // Einfügen der Kategorien in die `categories`-Tabelle
        $this->importCategories($categories['CodeList']['ThemaCodes']['Code']);
    }

    /**
     * Importiert Kategorien rekursiv in die Datenbank
     *
     * @param array $categories Array von Kategorien
     * @param int|null $parentId ID der übergeordneten Kategorie
     */
    private function importCategories(array $categories, $parentId = null)
    {
        foreach ($categories as $category) {
            // Einfügen der Kategorie in die Datenbank
            $newCategory = Category::create([
                'value' => $category['CodeValue'],
                'description' => $category['CodeDescription'] ?? null,
                'notes' => $category['CodeNotes'] ?? null,
                'parent_id' => $parentId,
            ]);

            // Falls es eine Unterkategorie gibt, rekursiv verarbeiten
            if (!empty($category['CodeParent'])) {
                $parentCategory = Category::where('value', $category['CodeParent'])->first();
                if ($parentCategory) {
                    $newCategory->parent_id = $parentCategory->id;
                    $newCategory->save();
                }
            }
        }
    }
}
