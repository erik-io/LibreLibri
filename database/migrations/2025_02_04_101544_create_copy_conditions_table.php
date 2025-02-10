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
     * Diese Methode erstellt die `copy_conditions`-Tabelle mit den Spalten `id`, `condition`, `label`, `created_at` und `updated_at`.
     * Zusätzlich werden mehrere Standardbedingungen in die Tabelle eingefügt.
     */
    public function up(): void
    {
        // Erstellen der `copy_conditions`-Tabelle
        Schema::create('copy_conditions', function (Blueprint $table) {
            $table->id(); // Primärschlüssel
            $table->string('condition')->unique(); // Eindeutige Bedingung
            $table->string('label')->nullable(); // Bezeichnung der Bedingung
            $table->timestamps(); // Zeitstempel für Erstellung und Aktualisierung
        });
    }

    /**
     * Macht die Migration rückgängig.
     *
     * Diese Methode löscht die `copy_conditions`-Tabelle.
     */
    public function down(): void
    {
        Schema::dropIfExists('copy_conditions'); // Löschen der `copy_conditions`-Tabelle
    }
};
