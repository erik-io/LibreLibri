<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    /**
     * Führt die Migration aus.
     *
     * Diese Methode erstellt die `condition_history`-Tabelle mit den Spalten `id`, `copy_id`, `old_condition_id`, `new_condition_id`, `changed_by`, `created_at` und `updated_at`.
     * Der Fremdschlüssel `copy_id` verweist auf die `copies`-Tabelle und löscht die Historie bei Löschung des Eintrags.
     * Die Fremdschlüssel `old_condition_id` und `new_condition_id` verweisen auf die `copy_conditions`-Tabelle und haben Standardwerte.
     * Der Fremdschlüssel `changed_by` verweist auf die `users`-Tabelle und setzt den Wert auf NULL bei Löschung des Nutzers.
     */
    public function up(): void
    {
        // Erstellen der `condition_history`-Tabelle
        Schema::create('condition_history', function (Blueprint $table) {
            $table->id(); // Primärschlüssel
            $table->foreignId('copy_id')->constrained('copies')->onDelete('cascade'); // Fremdschlüssel auf `copies` mit Löschweitergabe
            $table->foreignId('old_condition_id')->constrained('copy_conditions')->onDelete('restrict')->default(1); // Fremdschlüssel auf `copy_conditions` mit Standardwert 1 (neu)
            $table->foreignId('new_condition_id')->constrained('copy_conditions')->onDelete('restrict')->default(2); // Fremdschlüssel auf `copy_conditions` mit Standardwert 2 (gebraucht)
            $table->foreignId('changed_by')->nullable()->constrained('users')->onDelete('set null'); // Fremdschlüssel auf `users` mit Setzen auf NULL bei Löschung
            $table->timestamps(); // Zeitstempel für Erstellung und Aktualisierung
        });
    }

    /**
     * Macht die Migration rückgängig.
     *
     * Diese Methode löscht die `condition_history`-Tabelle.
     */
    public function down(): void
    {
        Schema::dropIfExists('condition_history'); // Löschen der `condition_history`-Tabelle
    }
};
