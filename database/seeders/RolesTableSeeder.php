<?php

namespace Database\Seeders;

use App\Models\Role;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class RolesTableSeeder extends Seeder
{
    /**
     * Führt den Datenbank Seeder aus.
     *
     * Diese Methode fügt eine Liste von Rollen in die `roles`-Tabelle ein.
     * Jede Rolle hat die Felder `name` und `description`.
     */
    public function run(): void
    {
        // Liste der Rollen, die eingefügt werden sollen
        $roles = [
            ['name' => 'admin', 'description' => 'Administrator'],
            ['name' => 'librarian', 'description' => 'Bibliothekar'],
            ['name' => 'user', 'description' => 'Benutzer'],
        ];

        // Einfügen der Rollen in die `roles`-Tabelle
        foreach ($roles as $role) {
            Role::create($role);
        };
    }
}
