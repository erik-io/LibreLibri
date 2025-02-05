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
     * Diese Methode erstellt die `library_settings`-Tabelle mit den Spalten `key`, `value`, `description`, `created_at` und `updated_at`.
     * Der Primärschlüssel ist die Spalte `key`.
     * Zusätzlich werden Standard-Einstellungen in die Tabelle eingefügt.
     */
    public function up(): void
    {
        // Erstellen der `library_settings`-Tabelle
        Schema::create('library_settings', function (Blueprint $table) {
            $table->string('key')->primary(); // Primärschlüssel
            $table->text('value'); // Wert der Einstellung
            $table->string('description')->nullable(); // Optionale Beschreibung der Einstellung
            $table->timestamps(); // Zeitstempel für Erstellung und Aktualisierung
        });
    }

    /**
     * Macht die Migration rückgängig.
     *
     * Diese Methode löscht die `library_settings`-Tabelle.
     */
    public function down(): void
    {
        Schema::dropIfExists('library_settings'); // Löschen der `library_settings`-Tabelle
    }
};
