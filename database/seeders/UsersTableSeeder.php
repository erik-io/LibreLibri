<?php

namespace Database\Seeders;

use App\Models\Role;
use App\Models\User;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\Hash;

class UsersTableSeeder extends Seeder
{
    /**
     * Standard-Passwörter für die verschiedenen Benutzerrollen.
     */
    private const PASSWORDS = [
        'admin' => 'admin123',
        'librarian' => 'librarian123',
        'user' => 'user123',
    ];

    /**
     * Führt den Datenbank Seeder aus.
     *
     * Diese Methode erstellt Benutzerkonten für Administratoren, Bibliothekare und normale Benutzer.
     * Es wird sichergestellt, dass die Rollen existieren, bevor die Benutzer erstellt werden.
     */
    public function run(): void
    {
        // Stelle sicher, dass die Rollen existieren
        if (Role::count() === 0) {
            $this->call(RolesTableSeeder::class);
        }

        // Erstelle einen Administrator-Account
        User::factory()->admin()->create([
            'username' => 'admin',
            'email' => 'admin@library.local',
            'first_name' => 'System',
            'last_name' => 'Administrator',
            'password' => Hash::make(self::PASSWORDS['admin']),
            'role_id' => 1, // Admin-Rolle
            'created_at' => now(),
            'updated_at' => now(),
        ]);

        // Erstelle einen Bibliothekar-Account
        User::factory()->librarian()->create([
            'username' => 'librarian',
            'email' => 'librarian@library.local',
            'first_name' => 'Library',
            'last_name' => 'Librarian',
            'password' => Hash::make(self::PASSWORDS['librarian']),
            'role_id' => 2, // Bibliothekar-Rolle
            'created_at' => now(),
            'updated_at' => now(),
        ]);

        // Erstelle einen normalen Benutzer-Account
        User::factory()->create([
            'username' => 'user',
            'email' => 'user@library.local',
            'first_name' => 'John',
            'last_name' => 'Doe',
            'password' => Hash::make(self::PASSWORDS['user']),
            'role_id' => 3, // Benutzer-Rolle
            'created_at' => now(),
            'updated_at' => now(),
        ]);

        // Erstelle einige Administratoren
        User::factory()->admin()->count(2)->create();

        // Erstelle einige Bibliothekare
        User::factory()->librarian()->count(3)->create();

        // Erstelle einige normale Benutzer
        User::factory()->count(50)->create();
    }
}
