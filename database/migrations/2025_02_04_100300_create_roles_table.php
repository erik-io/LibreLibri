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
     * Diese Methode erstellt die `roles`-Tabelle mit den Spalten `id`, `name`, `description`, `created_at` und `updated_at`.
     * Zusätzlich werden drei Standardrollen (`admin`, `librarian`, `user`) in die Tabelle eingefügt.
     */
    public function up(): void
    {
        // Erstellen der `roles`-Tabelle
        Schema::create('roles', function (Blueprint $table) {
            $table->id(); // Primärschlüssel
            $table->string('name')->unique(); // Eindeutiger Name der Rolle
            $table->string('description')->nullable(); // Optionale Beschreibung der Rolle
            $table->timestamps(); // Zeitstempel für Erstellung und Aktualisierung
        });

        // Einfügen der Standardrollen in die `roles`-Tabelle
        DB::table('roles')->insert([
            [
                'name' => 'admin',
                'description' => 'Administrator',
                'created_at' => now(),
                'updated_at' => now(),
            ],
            [
                'name' => 'librarian',
                'description' => 'Bibliothekar',
                'created_at' => now(),
                'updated_at' => now(),
            ],
            [
                'name' => 'user',
                'description' => 'Benutzer',
                'created_at' => now(),
                'updated_at' => now(),
            ],
        ]);
    }

    /**
     * Macht die Migration rückgängig.
     *
     * Diese Methode löscht die `roles`-Tabelle.
     */
    public function down(): void
    {
        // Löschen der `roles`-Tabelle
        Schema::dropIfExists('roles');
    }
};
