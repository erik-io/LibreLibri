<?php

namespace Database\Seeders;

use App\Models\Book;
use App\Models\Copy;
use App\Models\Loan;
use App\Models\LoanStatus;
use App\Models\LoanTransaction;
use App\Models\User;
use Database\Builders\LoanTransactionBuilder;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class DemoStateSeeder extends Seeder
{
    /**
     * Bereitet den Demo-Zustand vor:
     * - Leiht alle Exemplare von 2 Büchern aus
     * - Entfernt alle Exemplare eines Buches
     */

    public function run(): void
    {
        // Hole 3 zufällige Bücher für unsere Demo
        $books = Book::inRandomOrder()->take(3)->get();

        // Status "ausgeliehen" aus der Datenbank holen
        $loanedStatus = LoanStatus::where('status', 'loaned')->first();

        // Status "reserviert" aus der Datenbank holen
        $reservedStatus = LoanStatus::where('status', 'reserved')->first();

        DB::transaction(function () use ($books, $loanedStatus, $reservedStatus) {
            // 1. Erstes Buch: Alle Exemplare ausleihen
            $this->loanAllCopies($books[0], $loanedStatus);

            // 2. Zweites Buch: Alle Exemplare reservieren
            $this->reserveAllCopies($books[1], $reservedStatus);

            // 3. Drittes Buch: Alle Exemplare entfernen
            $copies = Copy::where('book_id', $books[2]->id)->get();
            foreach ($copies as $copy) {
                $copy->delete(); // Soft-Delete
            }
        });
    }

    /**
     * Leiht alle Exemplare eines Buches aus
     *
     * @param Book $book
     * @param LoanStatus $loanedStatus
     */
    private function loanAllCopies(Book $book, LoanStatus $loanedStatus): void
    {
        // Hole alle nicht gelöschten Exemplare des Buches
        $copies = Copy::where('book_id', $book->id)
            ->whereNull('deleted_at')
            ->get();

        // Hole zufälligen Benutzer
        $users = User::where('role_id', '!=', 1)
            ->whereNotIn('id', [1, 2, 3])
            ->inRandomOrder()
            ->take($copies->count())
            ->get();

        // Für jedes Exemplar
        foreach ($copies as $index => $copy) {
            $user = $users[$index];

            // Erstelle eine neue Ausleihtransaktion
            $builder = new LoanTransactionBuilder($user);
            $builder->addCopy($copy);

            // Setze das Ausleihdatum auf heute
            $builder->setLoanDate(now());

            // Erstelle die Ausleihe
            $builder->build();
        }
    }

    private function reserveAllCopies(Book $book, $reservedStatus)
    {
        $copies = Copy::where('book_id', $book->id)
            ->whereNull('deleted_at')
            ->get();

        $users = User::where('role_id', '!=', 1)
            ->whereNotIn('id', [1, 2, 3])
            ->inRandomOrder()
            ->take($copies->count())
            ->get();

        foreach ($copies as $index => $copy) {
            // Direkt eine Loan-Instanz erstellen für Reservierungen
            Loan::create([
                'copy_id' => $copy->id,
                'loan_transaction_id' => LoanTransaction::create([
                    'user_id' => $users[$index]->id,
                ])->id,
                'loan_status_id' => $reservedStatus->id,
                'loan_date' => now(),
                'due_date' => now()->addDays(2),
            ]);
        }
    }
}
