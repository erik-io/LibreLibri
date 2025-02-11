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
     * Diese Methode erstellt die `categories`-Tabelle mit den Spalten `id`, `code`, `name`, `description`, `created_at`, `updated_at` und `deleted_at`.
     * Zusätzlich werden mehrere Standardkategorien in die Tabelle eingefügt.
     */
    public function up(): void
    {
        // Erstellen der `categories`-Tabelle
        Schema::create('categories', function (Blueprint $table) {
            $table->id(); // Primärschlüssel
            $table->string('value')->unique()->comment('EDItEUR Thema-Code'); // Eindeutiger Code für das Genre
            $table->string('description')->nullable()->comment('Name der Kategorie'); // Name der Kategorie
            $table->text('notes')->nullable()->comment('Beschreibung der Kategorie'); // Optionale Beschreibung der Kategorie
            $table->foreignId('parent_id')->nullable()->constrained('categories')->nullOnDelete()->comment('Übergeordnete Kategorie'); // Hierarchie
            $table->timestamps(); // Zeitstempel für Erstellung und Aktualisierung
            $table->softDeletes(); // Soft-Delete Unterstützung
        });
    }

    /**
     * Macht die Migration rückgängig.
     *
     * Diese Methode löscht die `categories`-Tabelle.
     */
    public function down(): void
    {
        Schema::dropIfExists('categories'); // Löschen der `categories`-Tabelle
    }
};
