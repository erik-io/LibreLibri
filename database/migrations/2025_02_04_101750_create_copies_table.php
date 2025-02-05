<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    /**
     * Führt die Migration aus.
     *
     * Diese Methode erstellt die `copies`-Tabelle mit den Spalten `id`, `book_id`, `acquired_on`, `copy_condition_id`, `created_at`, `updated_at` und `deleted_at`.
     * Zusätzlich werden mehrere Indizes für die Spalten `copy_condition_id`, `book_id` und `acquired_on` gesetzt.
     */
    public function up(): void
    {
        // Erstellen der `copies`-Tabelle
        Schema::create('copies', function (Blueprint $table) {
            $table->id(); // Primärschlüssel
            $table->foreignId('book_id')->constrained('books'); // Fremdschlüssel auf `books`
            $table->date('acquired_on'); // Erwerbsdatum des Exemplars
            // Fremdschlüssel zum Zustand (statt ENUM)
            $table->foreignId('copy_condition_id')->constrained('copy_conditions')->onDelete('restrict'); // Fremdschlüssel auf `copy_conditions`
            $table->timestamps(); // Zeitstempel für Erstellung und Aktualisierung
            $table->softDeletes(); // Soft-Delete Unterstützung

            $table->index('copy_condition_id');  // Index auf `copy_condition_id` für Inventursuche nach Zustand

            // Index auf Kombination von `book_id` und `copy_condition_id` für Abfragen wie "Alle Exemplare eines Buchs mit bestimmtem Zustand"
            $table->index(['book_id', 'copy_condition_id']);

            // Index auf Kombination von `acquired_on` und `copy_condition_id` für Inventurabfragen (nach Erwerbsdatum und Zustand)
            $table->index(['acquired_on', 'copy_condition_id']);
        });
    }

    /**
     * Macht die Migration rückgängig.
     *
     * Diese Methode löscht die `copies`-Tabelle.
     */
    public function down(): void
    {
        Schema::dropIfExists('copies'); // Löschen der `copies`-Tabelle
    }
};
