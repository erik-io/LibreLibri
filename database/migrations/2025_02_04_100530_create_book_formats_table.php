<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    /**
     * Führt die Migration aus.
     *
     * Diese Methode erstellt die `book_formats`-Tabelle mit den Spalten `id`, `format`, `description`, `created_at` und `updated_at`.
     * Zusätzlich werden vier Standardformate (`hardcover`, `paperback`, `ebook`, `audiobook`) in die Tabelle eingefügt.
     */
    public function up(): void
    {
        // Erstellen der `book_formats`-Tabelle
        Schema::create('book_formats', function (Blueprint $table) {
            $table->id(); // Primärschlüssel
            $table->string('format')->unique(); // Eindeutiger Name des Formats
            $table->string('description')->nullable(); // Optionale Beschreibung des Formats
            $table->timestamps(); // Zeitstempel für Erstellung und Aktualisierung
        });
    }

    /**
     * Macht die Migration rückgängig.
     *
     * Diese Methode löscht die `book_formats`-Tabelle.
     */
    public function down(): void
    {
        // Löschen der `book_formats`-Tabelle
        Schema::dropIfExists('book_formats');
    }
};
