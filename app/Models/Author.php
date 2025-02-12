<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Author extends Model
{
    protected $fillable = [
        'first_name',
        'last_name',
        'created_at',
        'updated_at',
        'deleted_at'
    ];

    protected $dates = [
        'created_at',
        'updated_at',
        'deleted_at'
    ];

    /**
     * Gibt den vollständigen Namen des Autors zurück.
     *
     * @return string Der vollständige Name
     */
    public function getFullName(): string
    {
        return "{$this->first_name} {$this->last_name}";
    }
}
