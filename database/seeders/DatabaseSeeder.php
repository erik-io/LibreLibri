<?php

namespace Database\Seeders;

use App\Models\User;
// use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class DatabaseSeeder extends Seeder
{
    /**
     * Führt die Datenbank-Seeds aus.
     *
     * Diese Methode ruft die Seeder-Klassen auf, die die Datenbank mit den notwendigen Daten füllen.
     */
    public function run(): void
    {
        $this->call([
            RolesTableSeeder::class,
            UsersTableSeeder::class,
            AuthorsTableSeeder::class,
            BookFormatsTableSeeder::class,
            BooksTableSeeder::class,
            CategoriesTableSeeder::class,
            CopyConditionsTableSeeder::class,
            CopiesTableSeeder::class,
            LoanStatusesTableSeeder::class,
            LibrarySettingsTableSeeder::class
        ]);
    }
}
