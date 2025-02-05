<?php

namespace Database\Seeders;

use App\Models\CopyCondition;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class CopyConditionsTableSeeder extends Seeder
{
    /**
     * Führt den Datenbank Seeder aus.
     */
    public function run(): void
    {
        $copy_conditions = [
            [
                'condition' => 'new',
                'description' => 'Neu',
            ],
            [
                'condition' => 'used',
                'description' => 'Gebraucht',
            ],
            [
                'condition' => 'damaged',
                'description' => 'Beschädigt',
            ],
            [
                'condition' => 'lost',
                'description' => 'Verloren',
            ],
        ];

        foreach ($copy_conditions as $copy_condition) {
            CopyCondition::create($copy_condition);
        }
    }
}
