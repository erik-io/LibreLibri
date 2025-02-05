<?php

namespace Database\Seeders;

use App\Models\LibrarySettings;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class LibrarySettingsTableSeeder extends Seeder
{
    /**
     * Führt den Seeder aus.
     *
     * Diese Methode initialisiert die Grundeinstellungen der Bibliothek in der Datenbank.
     * Jede Einstellung besteht aus einem Schlüssel (key), einem Wert (value) und einer
     * optionalen Beschreibung (description).
     */
    public function run(): void
    {
        // Definition der Standardeinstellungen
        $settings = [
            [
                'key' => 'library_name',
                'value' => 'LibreLibri Bibliothek',
                'description' => 'Der Name der Bibliothek',
            ],
            [
                'key' => 'max_loan_days',
                'value' => '21',
                'description' => 'Maximale Ausleihdauer in Tagen',
            ],
            [
                'key' => 'max_loans_per_user',
                'value' => '5',
                'description' => 'Maximale Anzahl an Ausleihen pro Benutzer',
            ],
            [
                'key' => 'max_reservations_per_user',
                'value' => '3',
                'description' => 'Maximale Anzahl an Reservierungen pro Benutzer',
            ],
            [
                'key' => 'reservation_hold_days',
                'value' => '7',
                'description' => 'Anzahl der Tage, die ein reserviertes Buch zurückgehalten wird',
            ],
            [
                'key' => 'loan_fee_per_day',
                'value' => '0.50',
                'description' => 'Mahngebühr pro Tag in Euro',
            ],
            [
                'key' => 'email_reminder_days',
                'value' => '3',
                'description' => 'Tage vor Fälligkeit für Erinnerungsmail',
            ],
            [
                'key' => 'email_overdue_days',
                'value' => '7',
                'description' => 'Tage nach Fälligkeit für Mahnungsmail',
            ],
            [
                'key' => 'fine_limit',
                'value' => '10.00',
                'description' => 'Maximale Betrag an Mahngebühren, bevor das Konto gesperrt wird',
            ],
            [
                'key' => 'loan_extension_days',
                'value' => '7',
                'description' => 'Anzahl der Tage, um die Ausleihdauer zu verlängern',
            ],
            [
                'key' => 'max_loan_extensions',
                'value' => '2',
                'description' => 'Maximale Anzahl an Verlängerungen pro Buch',
            ]
        ];

        // Durchlaufen aller Einstellungen und Einfügen in die Datenbank
        foreach ($settings as $setting) {
            // Verwendung von updateOrCreate um Duplikate zu vermeiden
            LibrarySettings::updateOrCreate(
                ['key' => $setting['key']], // Suchkriterien
                $setting // Zu aktualisierende oder einzufügende Daten
            );
        }

    }
}
