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
     * Diese Methode modifiziert die `users`-Tabelle, indem sie die Spalte `name` löscht und die Spalten `username`, `first_name`, `last_name` und `role_id` hinzufügt.
     */
    public function up(): void
    {
        Schema::table('users', function (Blueprint $table) {
            // Spalte 'name' löschen
            $table->dropColumn('name');

            // Neue Spalten hinzufügen
            $table->string('username')->unique()->after('id'); // Eindeutiger Benutzername
            $table->string('first_name', 50)->after('username'); // Vorname des Benutzers
            $table->string('last_name', 50)->after('first_name'); // Nachname des Benutzers
            $table->foreignId('role_id')->after('email')->default(3)->constrained('roles')->onDelete('restrict'); // Fremdschlüssel zur `roles`-Tabelle
        });
    }

    /**
     * Macht die Migration rückgängig.
     *
     * Diese Methode stellt die `users`-Tabelle wieder her, indem sie die Spalten `username`, `first_name`, `last_name` und `role_id` löscht und die Spalte `name` wieder hinzufügt.
     */
    public function down(): void
    {
        Schema::table('users', function (Blueprint $table) {
            $table->dropForeign(['role_id']); // Fremdschlüssel löschen
            $table->dropColumn(['username', 'first_name', 'last_name', 'role_id']); // Spalten löschen

            // Falls nötig, 'name' wieder hinzufügen
            $table->string('name')->after('id'); // Spalte `name` wiederherstellen
        });
    }
};
