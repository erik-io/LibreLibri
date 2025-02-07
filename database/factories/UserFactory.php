<?php

namespace Database\Factories;

use App\Models\User;
use App\Models\Role;
use Illuminate\Database\Eloquent\Factories\Factory;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Str;

/**
 * Factory zur Generierung von Testbenutzern.
 *
 * @extends \Illuminate\Database\Eloquent\Factories\Factory<\App\Models\User>
 */
class UserFactory extends Factory
{
    protected static ?string $password;

    /**
     * Das Model, für das diese Factory zuständig ist.
     */
    protected $model = User::class;

    /**
     * Define the model's default state.
     *
     * @return array<string, mixed>
     */
    public function definition(): array
    {
        return [
            'username' => fake()->userName(),
            'first_name' => fake()->firstName(),
            'last_name' => fake()->lastName(),
            'email' => fake()->unique()->safeEmail(),
            'email_verified_at' => now(),
            'password' => static::$password ??= Hash::make('password'),
            'role_id' => Role::where('name', 'user')->first()->id,
            'remember_token' => Str::random(10),
        ];
    }

    /**
     * Gibt einen Administrator-Zustand für das Model zurück.
     */
    public function admin()
    {
        return $this->state(fn (array $attributes) => [
            'role_id' => Role::where('name', 'admin')->first()->id,
        ]);
    }

    /**
     * Gibt einen Bibliothekaren-Zustand für das Model zurück.
     */
    public function librarian()
    {
        return $this->state(fn (array $attributes) => [
            'role_id' => Role::where('name', 'librarian')->first()->id,
        ]);
    }

    /**
     * Gibt einen Benutzer-Zustand für das Model zurück.
     */
    public function user()
    {
        return $this->state(fn (array $attributes) => [
            'role_id' => Role::where('name', 'user')->first()->id,
        ]);
    }

    /**
     * Indicate that the model's email address should be unverified.
     */
    public function unverified(): static
    {
        return $this->state(fn (array $attributes) => [
            'email_verified_at' => null,
        ]);
    }
}
