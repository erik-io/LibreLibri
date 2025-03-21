<?php

namespace Database\Seeders;

use App\Models\Book;
use App\Models\ConditionHistory;
use App\Models\Copy;
use App\Models\User;
use Exception;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\Log;

class CopiesTableSeeder extends Seeder
{
    /**
     * Führt den Datenbank Seeder aus.
     *
     * Diese Methode fügt eine zufällige Anzahl von Exemplaren (2-5) für jedes Buch in die `copies`-Tabelle ein.
     * Jedes Exemplar hat die Felder `book_id`, `acquired_on` und `copy_condition_id`.
     * Für gebrauchte Exemplare wird zusätzlich eine Zustandshistorie in der `condition_histories`-Tabelle angelegt.
     */
    public function run(): void
    {
        // Alle Bücher aus der Datenbank abrufen
        $books = Book::all();

        foreach ($books as $book) {
            // Zufällige Anzahl von Exemplaren pro Buch (2 - 5)
            $numberOfCopies = rand(2, 5);

            for ($i = 0; $i < $numberOfCopies; $i++) {
                // Zufälliges Erwerbungsdatum in den letzten 2 Jahren
                $acquiredOn = now()->subDays(rand(0, 730))->toDateString();

                // Zustand zufällig auswählen (1 = neu, 2 = gebraucht)
                $condition_id = rand(1, 2);

                // Exemplar erstellen und speichern
                $copy = Copy::create([
                    'book_id' => $book->id,
                    'acquired_on' => $acquiredOn,
                    'copy_condition_id' => $condition_id,
                ]);

                // Zustandshistorie für gebrauchte Exemplare anlagen
                if ($condition_id === 2) {
                    try {
                        ConditionHistory::create([
                            'copy_id' => $copy->id,
                            'old_condition_id' => '1',
                            'new_condition_id' => '2',
                            'changed_by' => User::where('role_id', 2)->first()->id, // Referenz auf einen Bibliothekar
                        ]);
                    } catch (Exception $e) {
                        Log::error("Fehler beim Erstellen der Zustandshistorie für Exemplar $copy->id: " . $e->getMessage());
                    }
                }
            }
        }
    }
}
