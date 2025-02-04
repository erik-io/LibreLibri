<?php

namespace Database\Seeders;

use App\Models\Author;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class AuthorsTableSeeder extends Seeder
{
    /**
     * Führt den Datenbank Seeder aus.
     */
    public function run(): void
    {
        $authors = [
            [
                'first_name' => 'Stephen',
                'last_name' => 'King',
                'created_at' => now(),
                'updated_at' => now(),
            ],
            [
                'first_name' => 'J.K.',
                'last_name' => 'Rowling',
                'created_at' => now(),
                'updated_at' => now(),
            ],
            [
                'first_name' => 'Dan',
                'last_name' => 'Brown',
                'created_at' => now(),
                'updated_at' => now(),
            ],
            [
                'first_name' => 'George R.R.',
                'last_name' => 'Martin',
                'created_at' => now(),
                'updated_at' => now(),
            ],
            [
                'first_name' => 'J.R.R.',
                'last_name' => 'Tolkien',
                'created_at' => now(),
                'updated_at' => now(),
            ],
            [
                'first_name' => 'Agatha',
                'last_name' => 'Christie',
                'created_at' => now(),
                'updated_at' => now(),
            ],
            [
                'first_name' => 'Marc',
                'last_name' => 'Elsberg',
                'created_at' => now(),
                'updated_at' => now(),
            ],
            [
                'first_name' => 'Sebastian',
                'last_name' => 'Fitzek',
                'created_at' => now(),
                'updated_at' => now(),
            ],
            [
                'first_name' => 'Charlotte',
                'last_name' => 'Link',
                'created_at' => now(),
                'updated_at' => now(),
            ],
            [
                'first_name' => 'Frank',
                'last_name' => 'Schätzing',
                'created_at' => now(),
                'updated_at' => now(),
            ],
        ];

        foreach ($authors as $author) {
            Author::create($author);
        };
    }
}
