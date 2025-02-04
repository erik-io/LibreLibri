<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    /**
     * Führt die Migration aus.
     *
     * Diese Methode erstellt die `books_authors`-Tabelle mit den Spalten `book_id` und `author_id`.
     * Beide Spalten sind Fremdschlüssel, die auf die `books`- und `authors`-Tabellen verweisen und bei Löschung der referenzierten Einträge ebenfalls gelöscht werden.
     * Zusätzlich werden mehrere Indizes für die Spalten `author_id` und `book_id` sowie deren Kombinationen gesetzt.
     */
    public function up(): void
    {
        // Erstellen der `books_authors`-Tabelle
        Schema::create('books_authors', function (Blueprint $table) {
            $table->foreignId('book_id')->constrained('books')->onDelete('cascade'); // Fremdschlüssel auf `books` mit Löschweitergabe
            $table->foreignId('author_id')->constrained('authors')->onDelete('cascade'); // Fremdschlüssel auf `authors` mit Löschweitergabe
            $table->primary(['book_id', 'author_id']); // Primärschlüssel auf Kombination von `book_id` und `author_id`

            // Zusätzliche Indizes:
            $table->index(['author_id', 'book_id']); // Index auf Kombination von `author_id` und `book_id`
            $table->index(['book_id', 'author_id']); // Index auf Kombination von `book_id` und `author_id`
        });
    }

    /**
     * Macht die Migration rückgängig.
     *
     * Diese Methode löscht die `books_authors`-Tabelle.
     */
    public function down(): void
    {
        Schema::dropIfExists('books_authors'); // Löschen der `books_authors`-Tabelle
    }
};
