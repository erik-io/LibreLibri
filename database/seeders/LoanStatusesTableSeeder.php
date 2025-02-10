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
     * Jeder Status hat die Felder `status` und `label`.
     */
    public function run(): void
    {
        // Liste der Ausleihstatus, die eingefügt werden sollen
        $loan_statuses = [
            [
                'status' => 'available',
                'label' => 'Verfügbar',
            ],
            [
                'status' => 'reserved',
                'label' => 'Reserviert',
            ],
            [
                'status' => 'ready_for_pickup',
                'label' => 'Abholbereit',
            ],
            [
                'status' => 'loaned',
                'label' => 'Ausgeliehen',
            ],
            [
                'status' => 'overdue',
                'label' => 'Überfällig',
            ],
            [
                'status' => 'returned',
                'label' => 'Zurückgegeben',
            ]
        ];

        // Einfügen der Ausleihstatus in die `loan_statuses`-Tabelle
        foreach ($loan_statuses as $loan_status) {
            LoanStatus::create($loan_status);
        }
    }
}
