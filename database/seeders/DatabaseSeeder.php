<?php

namespace Database\Seeders;

use App\Models\User;
// use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class DatabaseSeeder extends Seeder
{
    /**
     * Seed the application's database.
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
            LibrarySettingsTableSeeder::class
        ]);
    }
}
