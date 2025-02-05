<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    /**
     * Erstellt die Transaktionstabelle für Ausleihen.
     *
     * Diese Methode erstellt die `loans`-Tabelle mit den Spalten `id`, `loan_transaction_id`, `copy_id`, `loan_date`, `due_date`, `return_date`, `loan_status_id`, `created_at`, `updated_at` und `deleted_at`.
     * Zusätzlich werden mehrere Indizes für die Spalten `loan_date`, `due_date`, `return_date` und die Kombination `loan_status_id` und `due_date` gesetzt.
     */
    public function up(): void
    {
        // Erstellen der `loans`-Tabelle
        Schema::create('loans', function (Blueprint $table) {
            $table->id(); // Primärschlüssel
            $table->foreignId('loan_transaction_id')->constrained('loan_transactions'); // Fremdschlüssel auf `loan_transactions`
            $table->foreignId('copy_id')->constrained('copies'); // Fremdschlüssel auf `copies`
            $table->date('loan_date')->nullable()->comment('Datum der Ausleihe'); // Datum der Ausleihe
            $table->date('due_date')->nullable()->comment('Fälligkeitsdatum'); // Fälligkeitsdatum
            $table->date('return_date')->nullable()->comment('Tatsächliches Rückgabedatum'); // Tatsächliches Rückgabedatum
            $table->foreignId('loan_status_id')->constrained('loan_statuses'); // Fremdschlüssel auf `loan_statuses`
            $table->timestamps(); // Zeitstempel für Erstellung und Aktualisierung
            $table->softDeletes(); // Soft-Delete Unterstützung

            // Zusätzliche Indizes:
            $table->index('loan_date'); // Index auf `loan_date`
            $table->index('due_date'); // Index auf `due_date`
            $table->index('return_date'); // Index auf `return_date`
            $table->index(['loan_status_id', 'due_date']); // Index auf Kombination von `loan_status_id` und `due_date` für Überprüfung überfälliger Bücher
        });
    }

    /**
     * Macht die Migration rückgängig.
     *
     * Diese Methode löscht die `loans`-Tabelle.
     */
    public function down(): void
    {
        Schema::dropIfExists('loans'); // Löschen der `loans`-Tabelle
    }
};
