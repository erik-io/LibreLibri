<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    /**
     * Führt die Migration aus.
     *
     * Diese Methode erstellt die `authors`-Tabelle mit den Spalten `id`, `first_name`, `last_name`, `created_at`, `updated_at` und `deleted_at`.
     * Zusätzlich wird ein Index auf die Kombination der Spalten `first_name` und `last_name` gesetzt.
     */
    public function up(): void
    {
        Schema::create('authors', function (Blueprint $table) {
            $table->id(); // Primärschlüssel
            $table->string('first_name', 50); // Vorname des Autors
            $table->string('last_name', 50); // Nachname des Autors
            $table->timestamps(); // Zeitstempel für Erstellung und Aktualisierung
            $table->softDeletes(); // Soft-Delete Unterstützung

            $table->index(['first_name', 'last_name']); // Index auf `first_name` und `last_name`
        });
    }

    /**
     * Macht die Migration rückgängig.
     *
     * Diese Methode löscht die `authors`-Tabelle.
     */
    public function down(): void
    {
        Schema::dropIfExists('authors'); // Löschen der `authors`-Tabelle
    }
};
