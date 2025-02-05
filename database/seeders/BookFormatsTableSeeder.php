<?php

namespace Database\Seeders;

use App\Models\BookFormat;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class BookFormatsTableSeeder extends Seeder
{
    /**
     * Führt den Datenbank Seeder aus.
     */
    public function run(): void
    {
        $formats = [
            ['format' => 'Hardcover', 'description' => 'Gebundene Ausgabe'],
            ['format' => 'Paperback', 'description' => 'Taschenbuch'],
            ['format' => 'E-Book', 'description' => 'Digitale Ausgabe'],
        ];

        foreach ($formats as $format) {
            BookFormat::create($format);
        }
    }
}
