<?php

namespace Database\Seeders;

use App\Models\BookFormat;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class BookFormatsTableSeeder extends Seeder
{
    /**
     * Führt den Datenbank Seeder aus.
     *
     * Diese Methode fügt eine Liste von Buchformaten in die `book_formats`-Tabelle ein.
     * Jedes Format hat die Felder `format` und `description`.
     */
    public function run(): void
    {
        // Liste der Buchformate, die eingefügt werden sollen
        $formats = [
            ['format' => 'Hardcover', 'description' => 'Gebundene Ausgabe'],
            ['format' => 'Paperback', 'description' => 'Taschenbuch'],
            ['format' => 'E-Book', 'description' => 'Digitale Ausgabe'],
        ];

        // Einfügen der Formate in die `book_formats`-Tabelle
        foreach ($formats as $format) {
            BookFormat::create($format);
        }
    }
}
