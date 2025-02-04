<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class ConditionHistory extends Model
{
    // Laravel erwartet standardmäßig den Namen condition_histories
    protected $table = 'condition_history';

    protected $fillable = [
        'copy_id',
        'old_condition_id',
        'new_condition_id',
        'changed_by'
    ];

    /**
     * Beziehung zum Exemplar (Copy)
     */
    public function copy()
    {
        return $this->belongsTo(Copy::class, 'copy_id');
    }
}
