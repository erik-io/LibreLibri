<?php

namespace Database\Factories;

use App\Models\Copy;
use App\Models\Loan;
use App\Models\LoanStatus;
use App\Models\LoanTransaction;
use App\Models\User;
use Database\Builders\LoanTransactionBuilder;
use Illuminate\Database\Eloquent\Factories\Factory;
use Illuminate\Support\Collection;
use Illuminate\Support\Facades\Date;

/**
 * Factory-Klasse für die Generierung von Ausleihen
 *
 * Diese Klasse ist verantwortlich für die Erstellung von Ausleihen,
 * wobei sie intern den LoanTransactionBuilder verwendet, um die technische
 * Implementierung der Mehrfachausleihen zu handhaben.
 */
class LoanFactory extends Factory
{
    /**
     * The name of the factory's corresponding model.
     *
     * @var string
     */
    protected $model = Loan::class;

    /**
     * Define the model's default state.
     *
     * @return array
     */
    public function definition()
    {
        return [
            'user_id' => null,
            'copy_id' => null,
            'loan_date' => now(),
            'return_date' => null
        ];
    }

    /**
     * Generiert eine Reihe von Ausleihen über einen Zeitraum
     *
     * @param int $count Gewünschte Anzahl von Ausleihen
     * @param \DateTime $startDate Startdatum für die Ausleihen
     * @param \DateTime $endDate Enddatum für die Ausleihen
     * @throws \Exception
     */
    public function generateLoans(int $count, $startDate, $endDate): void
    {
        // Hole alle Benutzer und verfügbaren Exemplare
        $users = User::where('role_id', '!=', 1)->whereNotIn('id', [1, 2, 3])->get(); // Nur normale Benutzer

        // Eager Loading der Beziehungen für weniger SQL-Abfragen und bessere Performance
        // https://laravel.com/docs/5.2/eloquent-relationships#eager-loading
        $copies = Copy::with('book')->get();

        // Status "zurückgegeben" aus der Datenbank abrufen
        $returnedStatus = LoanStatus::where('status', 'returned')->first();

        // Für jede gewünschte Ausleihtransaktion
        for ($i = 0; $i < $count; $i++) {
            // Wähle zufälligen Benutzer
            $user = $users->random();

            // Generiere zufälliges Ausleihdatum innerhalb des definierten Zeitraums
            $startTimestamp = Date::parse($startDate)->timestamp;
            $endTimestamp = Date::parse($endDate)->timestamp;
            $loanDate = Date::createFromTimestamp(rand($startTimestamp, $endTimestamp));

            // Erstelle Builder für diese Ausleihtransaktion
            $builder = new LoanTransactionBuilder($user);
            $builder->setLoanDate($loanDate);

            // Simuliere realistische Ausleihverhalten:
            // Die meisten Benutzer leihen 1-2 Bücher aus,
            // selten mehr als 3
            $numBooks = $this->getRandomBookCount();

            // Finde verfügbare Buchexemplare
            $availableCopies = $this->getAvailableCopies($copies, $loanDate);

            if ($availableCopies->count() < $numBooks) {
                // Wenn nicht genügend Exemplare verfügbar sind, überspringe diese Transaktion
                continue;
            }

            // Finde zufällige verfügbare Buchexemplare
            $selectedCopies = $availableCopies->random(
                min($numBooks, $availableCopies->count())
            );

            // Füge die ausgewählten Exemplare zum Builder hinzu
            foreach ($selectedCopies as $copy) {
                try {
                    $builder->addCopy($copy);
                } catch (\InvalidArgumentException $e) {
                    // Wenn ein Exemplar nicht hinzugefügt werden kann, überspringe diese Transaktion
                    continue 2;
                }
            }

            // Erstelle die Ausleihe
            try {
                $transaction = $builder->build();

                // Für jede Ausleihe in der Transaktion
                foreach ($transaction->loans as $loan) {
                    // Berechne die Wahrscheinlichkeit einer Rückgabe
                    $daysSinceLoan = $loanDate->diffInDays(now());

                    // Verschiedene Rückgabe-Szenarien mit unterschiedlichen Wahrscheinlichkeiten
                    if ($daysSinceLoan > 21 || rand(1, 100) <= 80) {
                        // Bestimmte das Rückgabeverhalten
                        $scenario = rand(1, 100);
                        if ($scenario <= 60) {
                            // 60 % - Pünktliche Rückgabe (bis 21 Tage)
                            $maxDays = 21;
                        } elseif ($scenario <= 90) {
                            // 30 % - Leicht verspätet (22-25 Tage)
                            $maxDays = 25;
                        } else {
                            // 10 % - Stark verspätet (26-30 Tage)
                            $maxDays = 30;
                        }
                    }

                    $minReturnDate = $loanDate->copy()->addDays(1);
                    $maxReturnDate = min(
                        $loanDate->copy()->addDays($maxDays),
                        now()
                    );

                    // Zufälliges Rückgabedatum innerhalb des erlaubten Zeitraums
                    $returnDate = Date::createFromTimestamp(
                        rand($minReturnDate->timestamp, $maxReturnDate->timestamp)
                    );

                    // Aktualisiere die Ausleihe
                    $loan->update([
                        'return_date' => $returnDate,
                        'loan_status_id' => $returnedStatus->id
                    ]);
                }
            } catch (\InvalidArgumentException $e) {
                // Wenn die Ausleihe nicht erstellt werden kann, überspringe diese Transaktion
                continue;
            }
        }
    }

    /**
     * Generiert eine realistische Anzahl von Büchern pro Ausleihe
     *
     * Die Verteilung ist:
     * - 60 % der Nutzer leihen 1 Buch aus
     * - 30 % der Nutzer leihen 2 Bücher aus
     * - 5 % der Nutzer leihen 3 Bücher aus
     *
     * @return int
     */
    private function getRandomBookCount(): int
    {
        $random = rand(1, 100);
        if ($random <= 60) { // 60 % der Nutzer leihen 1 Buch aus
            return 1;
        } elseif ($random <= 90) { // 30 % der Nutzer leihen 2 Bücher aus
            return 2;
        } elseif ($random <= 95) { // 5 % der Nutzer leihen 3 Bücher aus
            return 3;
        } else {
            return 0; // 5 % der Nutzer leihen 0 Bücher aus
        }
    }

    /**
     * Gibt eine Collection von verfügbaren Buchexemplaren für ein bestimmtes Datum zurück
     *
     * @param Collection $copies
     * @param $date
     * @return Collection
     */
    private function getAvailableCopies(Collection $copies, $date): Collection
    {
        return $copies->filter(function ($copy) use ($date) {
            return !$copy->loans()
                ->where('loan_date', '<=', $date)
                ->where(function ($query) use ($date) {
                    $query->whereNull('return_date')
                        ->orWhere('return_date', '>', $date);
                })
                ->exists();
        });
    }
}
