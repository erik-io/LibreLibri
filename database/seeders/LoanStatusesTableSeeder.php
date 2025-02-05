<?php

namespace Database\Seeders;

use App\Models\LoanStatus;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class LoanStatusesTableSeeder extends Seeder
{
    /**
     * Führt den Datenbank Seeder aus.
     *
     * Diese Methode fügt eine Liste von Ausleihstatus in die `loan_statuses`-Tabelle ein.
     * Jeder Status hat die Felder `status` und `description`.
     */
    public function run(): void
    {
        // Liste der Ausleihstatus, die eingefügt werden sollen
        $loan_statuses = [
            [
                'status' => 'available',
                'description' => 'Verfügbar',
            ],
            [
                'status' => 'reserved',
                'description' => 'Reserviert',
            ],
            [
                'status' => 'ready_for_pickup',
                'description' => 'Abholbereit',
            ],
            [
                'status' => 'loaned',
                'description' => 'Ausgeliehen',
            ],
            [
                'status' => 'overdue',
                'description' => 'Überfällig',
            ],
            [
                'status' => 'returned',
                'description' => 'Zurückgegeben',
            ]
        ];

        // Einfügen der Ausleihstatus in die `loan_statuses`-Tabelle
        foreach ($loan_statuses as $loan_status) {
            LoanStatus::create($loan_status);
        }
    }
}
