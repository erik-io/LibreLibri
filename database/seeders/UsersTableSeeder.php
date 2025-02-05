<?php

namespace Database\Seeders;

use App\Models\Role;
use App\Models\User;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\Hash;

class UsersTableSeeder extends Seeder
{
    private const DEFAULT_PASSWORD = [
        'admin' => 'admin123',
        'librarian' => 'librarian123',
        'user' => 'user123',
    ];

    /**
     * Führt den Datenbank Seeder aus.
     */
    public function run(): void
    {
        // Stelle sicher, dass die Rollen existieren
        if (Role::count() === 0) {
            $this->call(RoleTableSeeder::class);
        }

        // Erstelle einen Administrator-Account
        User::factory()->admin()->create([
            'username' => 'admin',
            'email' => 'admin@library.local',
            'first_name' => 'System',
            'last_name' => 'Administrator',
            'password' => Hash::make('admin123'), // In Produktions anders handhaben!
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
            'password' => Hash::make('librarian123'), // In Produktions anders handhaben!
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
            'password' => Hash::make('user123'), // In Produktions anders handhaben!
            'role_id' => 3, // Benutzer-Rolle
            'created_at' => now(),
            'updated_at' => now(),
        ]);

        // Erstelle einige Bibliothekare
        User::factory()->librarian()->count(3)->create();

        // Erstelle einige normale Benutzer
        User::factory()->count(50)->create();
    }
}
