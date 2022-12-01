<?php

declare(strict_types=1);

namespace Database\Factories;

use Illuminate\Database\Eloquent\Factories\Factory;
use MyCare\Shared\Infrastructure\User\Eloquent\EPersonalData;

/**
 * @extends \Illuminate\Database\Eloquent\Factories\Factory<\App\Models\Model>
 */
class EPersonalDataFactory extends Factory
{

    protected $model = EPersonalData::class;
    /**
     * Define the model's default state.
     *
     * @return array<string, mixed>
     */
    public function definition()
    {
        return [
            'contact_phone' => fake()->phoneNumber(),
            'weight' => fake()->numberBetween(50, 100),
            'height' => fake()->numberBetween(50, 100),
            'other_info' => fake()->paragraph(),
            'created_at' => fake()->dateTime(),
            'updated_at' => fake()->dateTime(),
        ];
    }

    public function incompleted()
    {
        return $this->state(
            function (array $attributes) {
                return [
                'contact_phone' => null,
                'weight' => null,
                'height' => null,
                'other_info' => null,
                ];
            }
        );
    }
}
