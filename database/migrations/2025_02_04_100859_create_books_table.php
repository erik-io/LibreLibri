<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    /**
     * Erstellt die Bücher-Tabelle.
     *
     * Diese Tabelle speichert die Grundinformationen zu allen Büchern
     * in der Bibliothek.
     */
    public function up(): void
    {
        Schema::create('books', function (Blueprint $table) {
            $table->id(); // Primärschlüssel
            $table->string('title'); // Titel des Buches
            $table->string('isbn10', 10)->unique()->nullable(); // Optional, da nicht alle Bücher ISBN-10 haben
            $table->string('isbn13', 13)->unique()
                ->comment('ISBN-13 nach internationalem Standard'); // ISBN-13 sollte Pflicht sein
            $table->unsignedInteger('edition')->default(1); // Ausgabe des Buches, Standardwert ist 1

            // Fremdschlüssel auf book_formats mit Standardwert 1 (hardcover)
            $table->foreignId('format_id')->default(1)->constrained('book_formats')->onDelete('restrict');

            $table->date('publication_date'); // Veröffentlichungsdatum des Buches
            $table->timestamps(); // Zeitstempel für Erstellung und Aktualisierung
            $table->softDeletes(); // Soft-Delete Unterstützung

            $table->index('title'); // Index auf `title`
            $table->index('isbn10'); // Index auf `isbn10`
            $table->index('isbn13'); // Index auf `isbn13`
            $table->index('publication_date'); // Index auf `publication_date`
            $table->index(['title', 'isbn13']); // Kombinierter Index auf `title` und `isbn13`
        });
    }

    /**
     * Macht die Migration rückgängig.
     *
     * Diese Methode löscht die `books`-Tabelle.
     */
    public function down(): void
    {
        Schema::dropIfExists('books'); // Löschen der `books`-Tabelle
    }
};
