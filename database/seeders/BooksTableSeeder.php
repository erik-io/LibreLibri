<?php

namespace Database\Seeders;

use App\Models\Book;
use App\Models\Category;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\Log;

class BooksTableSeeder extends Seeder
{
    /**
     * Führt die Datenbank-Seeds aus.
     *
     * Diese Methode fügt eine Liste von Büchern in die `books`-Tabelle ein.
     * Jedes Buch hat die Felder `title`, `isbn13`, `isbn10`, `edition`, `format_id`, `publication_date`, `authors` und `categories`.
     */
    public function run(): void
    {
        $books = [
            [
                'title' => 'Der Herr der Ringe - Die Gefährten',
                'isbn13' => '9783608938289',
                'isbn10' => '3608938281',
                'edition' => 1,
                'format_id' => 1, // Hardcover
                'publication_date' => '2001-01-01',
                'authors' => [5], // Tolkien
                'category_value' => 'FM' // Fantasyliteratur
            ],
            [
                'title' => 'Harry Potter und der Stein der Weisen',
                'isbn13' => '9783551557414',
                'isbn10' => '3551557411',
                'edition' => 1,
                'format_id' => 1, // Hardcover
                'publication_date' => '1998-07-21',
                'authors' => [2], // Rowling
                'category_value' => 'YF' // Kinder/Jugendliche: Romane, Erzählungen, Tatsachenberichte
            ],
            [
                'title' => 'Es',
                'isbn13' => '9783453435773',
                'isbn10' => '3453435770',
                'edition' => 1,
                'format_id' => 2, // Paperback
                'publication_date' => '1986-09-15',
                'authors' => [1], // King
                'category_value' => 'FKC' // Klassische Horror- und Geistergeschichten
            ],
            [
                'title' => 'Sakrileg',
                'isbn13' => '9783404148660',
                'isbn10' => '3404148665',
                'edition' => 1,
                'format_id' => 2, // Paperback
                'publication_date' => '2004-03-18',
                'authors' => [3], // Brown
                'category_value' => 'FHD' // Spionagethriller
            ],
            [
                'title' => 'Das Game',
                'isbn13' => '9783764506742',
                'isbn10' => '3764506741',
                'edition' => 1,
                'format_id' => 1, // Hardcover
                'publication_date' => '2019-09-09',
                'authors' => [7], // Elsberg
                'category_value' => 'FHD' // Spionagethriller
            ],
        ];

        foreach ($books as $bookData) {
            try {
                // Loggen der verarbeiteten Bücher
                Log::info("Verarbeite Buch: " . $bookData['title']);

                // Kategorie anhand des Werts abrufen
                $query = Category::where('value', $bookData['category_value']);

                // Loggen der SQL-Abfrage und der Bindings
                Log::info("SQL: " . $query->toSql());
                Log::info("Bindings: " . implode(", ", $query->getBindings()));

                $category = $query->first();
                if (!$category) {
                    // Loggen, wenn die Kategorie nicht gefunden wurde
                    Log::error("Kategorie nicht gefunden: " . $bookData['category_value']);
                    continue;
                }

                // Loggen der gefundenen Kategorie-ID
                Log::info("Gefundene Kategorie ID: " . $category->id);

                $book = Book::create([
                    'title' => $bookData['title'],
                    'isbn13' => $bookData['isbn13'],
                    'isbn10' => $bookData['isbn10'],
                    'edition' => $bookData['edition'],
                    'format_id' => $bookData['format_id'],
                    'publication_date' => $bookData['publication_date'],
                ]);

                $book->authors()->attach($bookData['authors']);
                $book->categories()->attach([$category->id]);

                // Loggen, wenn das Buch erfolgreich erstellt wurde
                Log::info("Buch erstellt und Kategorie verknüpft");
            } catch (\Exception $e) {
                // Loggen von Fehlern beim Erstellen des Buches
                Log::error("Fehler beim Erstellen des Buches {$bookData['title']}: " . $e->getMessage());
            }
        }
    }
}

