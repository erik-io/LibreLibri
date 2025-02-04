<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    /**
     * Führt die Migration aus.
     *
     * Diese Methode erstellt die `loan_history`-Tabelle mit den Spalten `id`, `loan_id`, `status_id`, `comment`, `created_at` und `updated_at`.
     * Zusätzlich werden mehrere Indizes für die Spalten `created_at`, `loan_id`, `status_id` und deren Kombinationen gesetzt.
     */
    public function up(): void
    {
        // Erstellen der `loan_history`-Tabelle
        Schema::create('loan_history', function (Blueprint $table) {
            $table->id(); // Primärschlüssel
            $table->foreignId('loan_id')->constrained('loans')->onDelete('cascade'); // Fremdschlüssel auf `loans` mit Löschweitergabe
            $table->foreignId('status_id')->constrained('loan_statuses'); // Fremdschlüssel auf `loan_statuses`
            $table->text('comment')->nullable(); // Optionale Kommentare/Notizen
            $table->timestamps(); // Zeitstempel für Erstellung und Aktualisierung

            // Zusätzliche Indizes:
            $table->index('created_at'); // Index auf `created_at`
            $table->index('loan_id'); // Index auf `loan_id`
            $table->index(['created_at', 'status_id']); // Index auf Kombination von `created_at` und `status_id` für Statistikabfragen
            $table->index(['loan_id', 'created_at']); // Index auf Kombination von `loan_id` und `created_at` für chronologische Abfragen der Ausleihhistorie
            $table->index(['status_id', 'created_at']); // Index auf Kombination von `status_id` und `created_at` für Statusänderungen in einem Zeitraum
        });
    }

    /**
     * Macht die Migration rückgängig.
     *
     * Diese Methode löscht die `loan_history`-Tabelle.
     */
    public function down(): void
    {
        Schema::dropIfExists('loan_history'); // Löschen der `loan_history`-Tabelle
    }
};
