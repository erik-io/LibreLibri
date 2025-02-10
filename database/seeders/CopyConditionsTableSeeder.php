<?php

namespace Database\Seeders;

use App\Models\CopyCondition;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class CopyConditionsTableSeeder extends Seeder
{
    /**
     * Führt den Datenbank Seeder aus.
     *
     * Diese Methode fügt eine Liste von Zuständen für Exemplare in die `copy_conditions`-Tabelle ein.
     * Jeder Zustand hat die Felder `condition` und `description`.
     */
    public function run(): void
    {
        // Liste der Zustände, die eingefügt werden sollen
        $copy_conditions = [
            [
                'condition' => 'new',
                'label' => 'Neu',
            ],
            [
                'condition' => 'used',
                'label' => 'Gebraucht',
            ],
            [
                'condition' => 'damaged',
                'label' => 'Beschädigt',
            ],
            [
                'condition' => 'lost',
                'label' => 'Verloren',
            ],
        ];

        // Einfügen der Zustände in die `copy_conditions`-Tabelle
        foreach ($copy_conditions as $copy_condition) {
            CopyCondition::create($copy_condition);
        }
    }
}
