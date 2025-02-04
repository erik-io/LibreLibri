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
     * Diese Methode erstellt die `copy_conditions`-Tabelle mit den Spalten `id`, `condition`, `description`, `created_at` und `updated_at`.
     * Zusätzlich werden mehrere Standardbedingungen in die Tabelle eingefügt.
     */
    public function up(): void
    {
        // Erstellen der `copy_conditions`-Tabelle
        Schema::create('copy_conditions', function (Blueprint $table) {
            $table->id(); // Primärschlüssel
            $table->string('condition')->unique(); // Eindeutige Bezeichnung des Zustands
            $table->string('description')->nullable(); // Optionale Beschreibung des Zustands
            $table->timestamps(); // Zeitstempel für Erstellung und Aktualisierung
        });

        // Einfügen der Standardbedingungen in die `copy_conditions`-Tabelle
        DB::table('copy_conditions')->insert([
            [
                'condition' => 'new',
                'description' => 'Neu',
                'created_at' => now(),
                'updated_at' => now(),
            ],
            [
                'condition' => 'used',
                'description' => 'Gebraucht',
                'created_at' => now(),
                'updated_at' => now(),
            ],
            [
                'condition' => 'damaged',
                'description' => 'Beschädigt',
                'created_at' => now(),
                'updated_at' => now(),
            ],
            [
                'condition' => 'lost',
                'description' => 'Verloren',
                'created_at' => now(),
                'updated_at' => now(),
            ],
        ]);
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
