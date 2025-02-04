<?php

namespace Database\Seeders;

use App\Models\Book;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class BooksTableSeeder extends Seeder
{
    /**
     * Führt die Datenbank-Seeds aus.
     */
    public function run(): void
    {
        // Bücher einfügen
        $books = [
            [
                'title' => 'Der Herr der Ringe - Die Gefährten',
                'isbn13' => '9783608938289',
                'isbn10' => '3608938281',
                'edition' => 1,
                'format_id' => 1, // Hardcover
                'publication_date' => '2001-01-01',
                'authors' => [5], // Tolkien
                'categories' => [2] // Fantasy
            ],
            [
                'title' => 'Harry Potter und der Stein der Weisen',
                'isbn13' => '9783551557414',
                'isbn10' => '3551557411',
                'edition' => 1,
                'format_id' => 1, // Hardcover
                'publication_date' => '1998-07-21',
                'authors' => [2], // Rowling
                'categories' => [6] // Kinderbücher
            ],
            [
                'title' => 'Es',
                'isbn13' => '9783453435773',
                'isbn10' => '3453435770',
                'edition' => 1,
                'format_id' => 2, // Paperback
                'publication_date' => '1986-09-15',
                'authors' => [1], // King
                'categories' => [5] // Horror
            ],
            [
                'title' => 'Sakrileg',
                'isbn13' => '9783404148660',
                'isbn10' => '3404148665',
                'edition' => 1,
                'format_id' => 2, // Paperback
                'publication_date' => '2004-03-18',
                'authors' => [3], // Brown
                'categories' => [5] // Thriller
            ],
            [
                'title' => 'Das Game',
                'isbn13' => '9783764506742',
                'isbn10' => '3764506741',
                'edition' => 1,
                'format_id' => 1, // Hardcover
                'publication_date' => '2019-09-09',
                'authors' => [7], // Elsberg
                'categories' => [5] // Thriller
            ],
        ];

        foreach ($books as $book)
        {
            // Buch mit Eloquent erstellen
            $book = Book::create([
                'title' => $book['title'],
                'isbn13' => $book['isbn13'],
                'isbn10' => $book['isbn10'],
                'edition' => $book['edition'],
                'format_id' => $book['format_id'],
                'publication_date' => $book['publication_date'],
            ]);

            // Autoren verknüpfen
            $book->authors()->attach($book['authors']);

            // Kategorien verknüpfen
            $book->categories()->attach($book['categories']);
        }
    }
}
