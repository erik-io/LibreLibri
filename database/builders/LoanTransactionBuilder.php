<?php

namespace Database\Builders;

use App\Models\Copy;
use App\Models\Loan;
use App\Models\LoanStatus;
use App\Models\LoanTransaction;
use App\Models\User;
use Illuminate\Support\Facades\Date;
use Illuminate\Support\Facades\DB;

/**
 * Builder-Klasse für die Erstellung von Mehrfachausleihungen
 *
 * Diese Klasse implementiert das Builder Pattern, um den komplexen Prozess
 * der Erstellung von Mehrfachausleihungen zu vereinfachen und zu kapseln.
 */
class LoanTransactionBuilder
{
    private User $user;
    private array $copies = [];
    private $loanDate;
    private $dueDate = null;
    private int $defaultLoanDuration = 21;

    /**
     * Konstruktor setzt den ausleihenden Benutzer
     */
    public function __construct(User $user)
    {
        $this->user = $user;
        $this->loanDate = now();
    }

    /**
     * Prüft, ob ein Buchexemplar verfügbar ist
     */
    private function isCopyAvailable(Copy $copy): bool
    {
        // Prüfe, ob das Buchexemplar bereits ausgeliehen ist
        if ($copy->loans()->whereNull('return_date')->exists()) {
            return false;
        }

        // Prüfe, ob das Buchexemplar gelöscht ist
        if ($copy->deleted_at !== null) {
            return false;
        }

        return true;
    }


    /**
     * Fügt ein Buchexemplar zur Ausleihe hinzu
     */
    public function addCopy(Copy $copy): self
    {
        // Prüfe, ob das Buchexemplar noch verfügbar ist
        // (z.B. nicht bereits ausgeliehen oder gelöscht)
        if (!$this->isCopyAvailable($copy)) {
            throw new \InvalidArgumentException("Exemplar {$copy->id} ist nicht verfügbar.");
        };

        $this->copies[] = $copy;
        return $this;
    }

    /**
     * Setzt das Ausleihdatum
     */
    public function setLoanDate($date): self
    {
        $this->loanDate = $date;
        return $this;
    }

    /**
     * Setzt das Fälligkeitsdatum
     */
    public function setDueDate($date): self
    {
        $this->dueDate = $date;
        return $this;
    }

    /**
     * Erstellt die Transaktion und alle zugehörigen Ausleihen
     */
    public function build(): LoanTransaction
    {
        if (empty($this->copies)) {
            throw new \InvalidArgumentException("Mindestens ein Buchexemplar muss hinzugefügt werden.");
        }

        // Standardmäßiges Fälligkeitsdatum berechnen falls nicht gesetzt
        if (!$this->dueDate) {
            $this->dueDate = $this->loanDate->copy()->addDays($this->defaultLoanDuration);
        }

        // Status "ausgeliehen" aus der Datenbank abrufen
        $loanedStatus = LoanStatus::where('status', 'loaned')->first();

        // DB::transaction(): Führt die umschlossenen Datenbankoperationen als eine Transaktion aus.
        // Falls ein Fehler auftritt, werden alle Änderungen rückgängig gemacht (rollback).
        return DB::transaction(function () use ($loanedStatus) {
            // Neue Ausleihtransaktion erstellen
            $transaction = LoanTransaction::create([
                'user_id' => $this->user->id,
            ]);

            // Für jedes Buchexemplar eine Ausleihe erstellen
            foreach ($this->copies as $copy) {
                Loan::Create([
                    'loan_transaction_id' => $transaction->id,
                    'copy_id' => $copy->id,
                    'loan_date' => $this->loanDate,
                    'due_date' => $this->dueDate,
                    'loan_status_id' => $loanedStatus->id,
                ]);
            }

            return $transaction->load('loans');
        });
    }

}
