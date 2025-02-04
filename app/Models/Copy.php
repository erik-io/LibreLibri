<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Copy extends Model
{
    protected $fillable = [
        'book_id',
        'acquired_on',
        'condition_id',
    ];

    /**
     * Beziehung zum Buch
     */
    public function book()
    {
        return $this->belongsTo(Book::class, 'book_id');
    }

    /**
     * Beziehung zur Zustandshistorie
     */
    public function conditionHistory()
    {
        return $this->hasMany(ConditionHistory::class, 'copy_id');
    }
}
