<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\SoftDeletes;

/**
 * Repräsentiert eine Ausleihe
 *
 * @property int $id
 * @property int $loan_transaction_id
 * @property int $copy_id
 * @property \DateTime $loan_date
 * @property \DateTime $due_date
 * @property \DateTime|null $return_date
 * @property int $loan_status_id
 * @property \DateTime $created_at
 * @property \DateTime $updated_at
 * @property \DateTime|null $deleted_at
 */
class Loan extends Model
{
    use HasFactory, SoftDeletes;
    protected $fillable = [
        'loan_transaction_id',
        'copy_id',
        'loan_date',
        'due_date',
        'return_date',
        'loan_status_id',
    ];

    protected $dates = [
        'loan_date',
        'due_date',
        'return_date',
        'created_at',
        'updated_at',
        'deleted_at',
    ];

    /**
     * Beziehung zur Transaktion
     *
     * @return BelongsTo
     */
    public function transaction(): BelongsTo
    {
        return $this->belongsTo(LoanTransaction::class);
    }

    /**
     * Beziehung zum Exemplar (Copy)
     *
     * @return BelongsTo
     */
    public function copy(): BelongsTo
    {
        return $this->belongsTo(Copy::class);
    }

    /**
     * Beziehung zum Status der Ausleihe
     *
     * @return BelongsTo
     */
    public function status(): BelongsTo
    {
        return $this->belongsTo(LoanStatus::class);
    }

    /**
     * Beziehung zum Ausleihhistorie
     *
     * @return BelongsTo
     */
    public function history(): BelongsTo
    {
        return $this->belongsTo(LoanHistory::class);
    }
}
