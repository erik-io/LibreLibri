<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\HasMany;
use Illuminate\Database\Eloquent\SoftDeletes;

/**
 * Modell für ein Buchexemplar
 *
 * @property int $id
 * @property int $book_id
 * @property \DateTime $acquired_on
 * @property int $copy_condition_id
 * @property \DateTime $created_at
 * @property \DateTime $updated_at
 * @property \DateTime|null $deleted_at
 */
class Copy extends Model
{
    use HasFactory, SoftDeletes;
    protected $fillable = [
        'book_id',
        'acquired_on',
        'copy_condition_id',
    ];

    protected $dates = [
        'acquired_on',
        'created_at',
        'updated_at',
        'deleted_at',
    ];

    public function isAvailable(): bool
    {
        $availableStatus = cache()->remember('loan_status_available', 3600, function () {
            return LoanStatus::whereIn('status', ['available', 'returned'])
                ->pluck('id')
                ->toArray();
        });

        $latestLoan = $this->loans()->latest()->first();
        // Ein Exemplar ist verfügbar, wenn es entweder keine Ausleihe hat
        // oder der letzte Status 'available' oder 'returned' ist
        return !$latestLoan || in_array($latestLoan->loan_status_id, $availableStatus);
    }

    public function isReserved(): bool
    {
        $reservedStatus = cache()->remember('loan_status_reserved', 3600, function () {
            return LoanStatus::whereIn('status', ['reserved', 'ready_for_pickup'])
                ->pluck('id')
                ->toArray();
        });

        $latestLoan = $this->loans()->latest()->first();
        return $latestLoan && in_array($latestLoan->loan_status_id, $reservedStatus);
    }

    public function isLoaned(): bool
    {
        $loanedStatus = cache()->remember('loan_status_loaned', 3600, function () {
            return LoanStatus::whereIn('status', ['loaned', 'overdue'])
                ->pluck('id')
                ->toArray();
        });

        $latestLoan = $this->loans()->latest()->first();
        return $latestLoan && in_array($latestLoan->loan_status_id, $loanedStatus);
    }

    /**
     * Gibt den aktuellen Status des Exemplars als String zurück
     * Dies ist nützlich für die API-Ressource
     */
    public function getCurrentStatus(): string
    {
        if ($this->isAvailable()) {
            return 'available';
        }
        if ($this->isReserved()) {
            return 'reserved';
        }
        if ($this->isLoaned()) {
            return 'loaned';
        }
        return 'unavailable';
    }

    /**
     * Beziehung zum zugehörigen Buch
     *
     * @return BelongsTo
     */
    public function book(): BelongsTo
    {
        return $this->belongsTo(Book::class);
    }

    /**
     * Beziehung zum aktuellen Zustand
     *
     * @return BelongsTo
     */
    public function condition(): BelongsTo
    {
        return $this->belongsTo(CopyCondition::class); // Laravel erwartet standardmäßig den Namen copy_condition_id
    }

    /**
     * Beziehung zur Zustandshistorie
     */
    public function conditionHistory()
    {
        return $this->hasMany(ConditionHistory::class);
    }

    /**
     * Beziehung zu den Ausleihen
     */
    public function loans(): HasMany
    {
        return $this->hasMany(Loan::class);
    }
}
