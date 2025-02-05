<?php

namespace Database\Seeders;

use App\Models\LoanStatus;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class LoanStatusesTableSeeder extends Seeder
{
    /**
     * Führt den Datenbank Seeder aus.
     */
    public function run(): void
    {
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

        foreach ($loan_statuses as $loan_status) {
            LoanStatus::create($loan_status);
        }
    }
}
