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
     * Diese Methode erstellt die `loan_statuses`-Tabelle mit den Spalten `id`, `status`, `description`, `created_at` und `updated_at`.
     * Zusätzlich werden mehrere Standard-Leihstatus in die Tabelle eingefügt.
     */
    public function up(): void
    {
        // Erstellen der `loan_statuses`-Tabelle
        Schema::create('loan_statuses', function (Blueprint $table) {
            $table->id(); // Primärschlüssel
            $table->string('status', 50)->unique(); // Eindeutiger Status
            $table->string('description'); // Beschreibung des Status
            $table->timestamps(); // Zeitstempel für Erstellung und Aktualisierung
        });

        // Einfügen der Standard-Leihstatus in die `loan_statuses`-Tabelle
        DB::table('loan_statuses')->insert([
            [
                'status' => 'available',
                'description' => 'Verfügbar',
                'created_at' => now(),
                'updated_at' => now()
            ],
            [
                'status' => 'reserved',
                'description' => 'Reserviert',
                'created_at' => now(),
                'updated_at' => now()
            ],
            [
                'status' => 'ready_for_pickup',
                'description' => 'Abholbereit',
                'created_at' => now(),
                'updated_at' => now()
            ],
            [
                'status' => 'loaned',
                'description' => 'Ausgeliehen',
                'created_at' => now(),
                'updated_at' => now()
            ],
            [
                'status' => 'overdue',
                'description' => 'Überfällig',
                'created_at' => now(),
                'updated_at' => now()
            ],
            [
                'status' => 'returned',
                'description' => 'Zurückgegeben',
                'created_at' => now(),
                'updated_at' => now()
            ]
        ]);
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
