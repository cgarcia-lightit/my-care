<?php

declare(strict_types=1);

namespace Database\Factories;

use Illuminate\Database\Eloquent\Factories\Factory;
use Illuminate\Support\Str;
use MyCare\Shared\Domain\ValueObj\Identifier;
use MyCare\Shared\Infrastructure\User\Eloquent\EPersonalData;
use MyCare\Shared\Infrastructure\User\Eloquent\EUserType;
use MyCare\Shared\Infrastructure\User\Eloquent\User;

class UserFactory extends Factory
{
    protected $model = User::class;

    /**
     * Define the model's default state.
     *
     * @return array<string, mixed>
     */
    public function definition()
    {
        return [
            'id' => (new Identifier())->get(),
            'name' => fake()->name(),
            'email' => fake()->unique()->safeEmail(),
            'email_verified_at' => now(),
            'type_id' => EUserType::factory(),
            'password' => '$2y$10$92IXUNpkjO0rOQ5byMi.Ye4oKoEa3Ro9llC/.og/at2.uheWG/igi', // password
            'remember_token' => Str::random(10),
        ];
    }

    /**
     * Indicate that the model's email address should be unverified.
     *
     * @return static
     */
    public function unverified()
    {
        return $this->state(
            fn(array $attributes) => [
            'email_verified_at' => null,
            ]
        );
    }
}
