<?php

namespace App\Models;

// use Illuminate\Contracts\Auth\MustVerifyEmail;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Notifications\Notifiable;

/**
 * User-Modell: Repräsentiert einen Benutzer in der Datenbank.
 *
 * @property int $id
 * @property string $username
 * @property int $role_id
 * @property string $first_name
 * @property string $last_name
 * @property string $email
 * @property \DateTime|null $email_verified_at
 * @property string $password
 * @property string $remember_token
 * @property \DateTime $created_at
 * @property \DateTime $updated_at
 */
class User extends Authenticatable
{
    /** @use HasFactory<\Database\Factories\UserFactory> */
    use HasFactory, Notifiable;

    /**
     * Die Attribute, die zugewiesen werden dürfen.
     *
     * @var list<string>
     */
    protected $fillable = [
        'username',
        'role_id',
        'first_name',
        'last_name',
        'email',
        'email_verified_at',
        'password',
    ];

    /**
     * Die Attribute, die als Datum behandelt werden.
     *
     * @var string[]
     */
    protected $dates = [
        'email_verified_at',
    ];

    /**
     * Die Attribute, die versteckt werden sollen.
     *
     * @var list<string>
     */
    protected $hidden = [
        'password',
        'remember_token',
    ];

    /**
     * Die Attribute, die gecastet werden sollen.
     *
     * @return array<string, string>
     */
    protected function casts(): array
    {
        return [
            'email_verified_at' => 'datetime',
            'password' => 'hashed',
        ];
    }

    /**
     * Die Beziehung zu den Rollen des Benutzers.
     *
     * @return BelongsTo
     */
    function role(): BelongsTo
    {
        return $this->belongsTo(Role::class);
    }

    /**
     * Überprüft, ob der Benutzer eine bestimmte Rolle hat.
     *
     * @param string $role Der Name der zu überprüfenden Rolle.
     * @return bool
     */
    public function hasRole($role): bool
    {
        return $this->role->name === $role;
    }
}
