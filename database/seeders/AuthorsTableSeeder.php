<?php

namespace Database\Seeders;

use App\Models\Author;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class AuthorsTableSeeder extends Seeder
{
    /**
     * Führt den Datenbank Seeder aus.
     *
     * Diese Methode fügt eine Liste von Autoren in die `authors`-Tabelle ein.
     * Jeder Autor hat die Felder `first_name` und `last_name`.
     */
    public function run(): void
    {
        // Liste der Autoren, die eingefügt werden sollen
        $authors = [
            ['first_name' => 'Stephen', 'last_name' => 'King'],
            ['first_name' => 'J.K.', 'last_name' => 'Rowling'],
            ['first_name' => 'Dan', 'last_name' => 'Brown'],
            ['first_name' => 'George R.R.', 'last_name' => 'Martin'],
            ['first_name' => 'J.R.R.', 'last_name' => 'Tolkien'],
            ['first_name' => 'Agatha', 'last_name' => 'Christie'],
            ['first_name' => 'Marc', 'last_name' => 'Elsberg'],
            ['first_name' => 'Sebastian', 'last_name' => 'Fitzek'],
            ['first_name' => 'Charlotte', 'last_name' => 'Link'],
            ['first_name' => 'Frank', 'last_name' => 'Schätzing']
        ];

        // Einfügen der Autoren in die `authors`-Tabelle
        foreach ($authors as $author) {
            Author::create($author);
        };
    }
}
