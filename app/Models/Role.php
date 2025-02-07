<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\HasMany;

/**
 * Role-Modell: Repräsentiert eine Rolle in der Datenbank.
 *
 * @property int $id
 * @property string $name
 * @property string $description
 * @property \DateTime $created_at
 * @property \DateTime $updated_at
 */
class Role extends Model
{
    /**
     * Die Attribute, die zugewiesen werden dürfen.
     *
     * @var string[]
     */
    protected $fillable =
        [
            'name',
            'description',
        ];

    /**
     * Die Attribute, die als Datum behandelt werden sollen.
     *
     * @var string[]
     */
    protected $dates = [
        'created_at',
        'updated_at',
    ];

    /**
     * Die Beziehung zu den Benutzern, die diese Rolle haben.
     *
     * @return HasMany
     */
    public function users(): hasMany
    {
        return $this->hasMany(User::class);
    }
}
