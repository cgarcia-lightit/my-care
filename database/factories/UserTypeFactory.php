<?php

declare(strict_types=1);

namespace Database\Factories;

use DateTime;
use Illuminate\Database\Eloquent\Factories\Factory;
use MyCare\Shared\Domain\ValueObj\Identifier;
use MyCare\Shared\Infrastructure\User\Eloquent\EUserType;

final class UserTypeFactory extends Factory
{
    protected $model = EUserType::class;

    public function definition(): array
    {
        return [
            'id' => (new Identifier())->get(),
            'created_at' => (new DateTime())->format('Y-m-d H:i:s'),
            'updated_at' => (new DateTime())->format('Y-m-d H:i:s'),
            'deleted_at' => null
        ];
    }
}
