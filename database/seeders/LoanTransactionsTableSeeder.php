<?php

namespace Database\Seeders;

use Database\Factories\LoanFactory;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\Log;

class LoanTransactionsTableSeeder extends Seeder
{
    /**
     * Führt den Datenbank-Seeder aus.
     *
     * Dieser Seeder generiert realistische Ausleihvorgänge über einem Zeitraum
     * von einem Jahr. Er nutzt den LoanCreator, der intern den Builder
     * für die technische Umsetzung der Mehrfachausleihen verwendet.
     *
     * @throws \Exception
     */
    public function run(): void
    {
        try {
            $factory = new LoanFactory();

            // Definiere Zeitraum für die Ausleihen (letzes Jahr bis heute)
            $startDate = now()->subYear();
            $endDate = now();

            // Generiere durchschnitt 2 Ausleihtransaktionen pro Tag.
            // Berechnet die Anzahl der Tage zwischen $startDate und $endDate
            // und multipliziert diese mit 2. Jede Tagesdifferenz wird mit 2 multipliziert.
            // Beispiel: 10 Tage * 2 = 20 Ausleihen
            $numberOfLoans = $startDate->diffInDays($endDate) * 2;

            // Generiere die Ausleihen
            $factory->generateLoans($numberOfLoans, $startDate, $endDate);
        } catch (\Exception $e) {
            Log::error('Fehler beim Seeden der Ausleihen: ' . $e->getMessage());
            throw $e;
        }
    }
}
