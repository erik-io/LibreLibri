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
     * Diese Methode erstellt die `loan_statuses`-Tabelle mit den Spalten `id`, `status`, `label`, `created_at` und `updated_at`.
     * Zusätzlich werden mehrere Standard-Leihstatus in die Tabelle eingefügt.
     */
    public function up(): void
    {
        // Erstellen der `loan_statuses`-Tabelle
        Schema::create('loan_statuses', function (Blueprint $table) {
            $table->id(); // Primärschlüssel
            $table->string('status')->unique(); // Eindeutiger Status
            $table->string('label'); // Bezeichnung des Status
            $table->timestamps(); // Zeitstempel für Erstellung und Aktualisierung
        });
    }

    /**
     * Macht die Migration rückgängig.
     *
     * Diese Methode löscht die `loan_statuses`-Tabelle.
     */
    public function down(): void
    {
        Schema::dropIfExists('loan_statuses'); // Löschen der `loan_statuses`-Tabelle
    }
};
