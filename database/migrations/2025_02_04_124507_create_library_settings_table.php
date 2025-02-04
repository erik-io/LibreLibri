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

        // Standard-Einstellungen einfügen
        DB::table('library_settings')->insert([
            [
                'key' => 'max_loan_days',
                'value' => '21',
                'description' => 'Maximale Ausleihdauer in Tagen',
                'created_at' => now(),
                'updated_at' => now(),
            ],
            [
                'key' => 'max_loans_per_user',
                'value' => '5',
                'description' => 'Maximale gleichzeitige Ausleihen pro Benutzer',
                'created_at' => now(),
                'updated_at' => now(),
            ],
            [
                'key' => 'reservation_hold_days',
                'value' => '7',
                'description' => 'Anzahl der Tage, die ein reserviertes Buch zurückgehalten wird',
                'created_at' => now(),
                'updated_at' => now(),
            ],
            [
                'key' => 'late_fee_per_day',
                'value' => '0.50',
                'description' => 'Mahngebühr pro Tag in Euro',
                'created_at' => now(),
                'updated_at' => now(),
            ],
            [
                'key' => 'email_reminder_days',
                'value' => '3',
                'description' => 'Tage vor Fälligkeit für Erinnerungs-E-Mail',
                'created_at' => now(),
                'updated_at' => now(),
            ]
        ]);
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
