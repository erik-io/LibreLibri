<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    /**
     * Führt die Migration aus.
     *
     * Diese Methode erstellt die `loan_transactions`-Tabelle mit den Spalten `id`, `user_id`, `created_at` und `updated_at`.
     * Der Fremdschlüssel `user_id` verweist auf die `users`-Tabelle und löscht die Transaktion bei Löschung des Nutzers.
     */
    public function up(): void
    {
        Schema::create('loan_transactions', function (Blueprint $table) {
            $table->id(); // Primärschlüssel
            $table->foreignId('user_id')->constrained('users')->onDelete('cascade'); // Fremdschlüssel auf `users` mit Löschweitergabe
            $table->timestamps(); // Zeitstempel für Erstellung und Aktualisierung
        });
    }

    /**
     * Macht die Migration rückgängig.
     *
     * Diese Methode löscht die `loan_transactions`-Tabelle.
     */
    public function down(): void
    {
        Schema::dropIfExists('loan_transactions'); // Löschen der `loan_transactions`-Tabelle
    }
};
