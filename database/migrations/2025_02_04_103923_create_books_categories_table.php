<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    /**
     * Führt die Migration aus.
     *
     * Diese Methode erstellt die `books_categories`-Tabelle mit den Spalten `book_id` und `category_id`.
     * Beide Spalten sind Fremdschlüssel, die auf die `books`- und `categories`-Tabellen verweisen und bei Löschung der referenzierten Einträge ebenfalls gelöscht werden.
     * Zusätzlich wird ein Index für die Kombination der Spalten `category_id` und `book_id` gesetzt, um Abfragen wie "Alle Bücher in einer Kategorie" zu unterstützen.
     */
    public function up(): void
    {
        // Erstellen der `books_categories`-Tabelle
        Schema::create('books_categories', function (Blueprint $table) {
            $table->foreignId('book_id')->constrained('books')->onDelete('cascade'); // Fremdschlüssel auf `books` mit Löschweitergabe
            $table->foreignId('category_id')->constrained('categories')->onDelete('cascade'); // Fremdschlüssel auf `categories` mit Löschweitergabe
            $table->primary(['book_id', 'category_id']); // Primärschlüssel auf Kombination von `book_id` und `category_id`
            $table->timestamps(); // Zeitstempel für Erstellung und Aktualisierung

            // Zusätzlicher Index:
            $table->index(['category_id', 'book_id']); // Index auf Kombination von `category_id` und `book_id` für Abfragen wie "Alle Bücher in einer Kategorie"
        });
    }

    /**
     * Macht die Migration rückgängig.
     *
     * Diese Methode löscht die `books_categories`-Tabelle.
     */
    public function down(): void
    {
        Schema::dropIfExists('books_categories'); // Löschen der `books_categories`-Tabelle
    }
};
