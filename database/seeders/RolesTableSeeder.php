<?php

namespace Database\Seeders;

use App\Models\Role;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class RolesTableSeeder extends Seeder
{
    /**
     * Führt den Datenbank Seeder aus.
     */
    public function run(): void
    {
        $roles = [
            ['name' => 'admin', 'description' => 'Administrator'],
            ['name' => 'librarian', 'description' => 'Bibliothekar'],
            ['name' => 'user', 'description' => 'Benutzer'],
        ];

        foreach ($roles as $role) {
            Role::create($role);
        };
    }
}
