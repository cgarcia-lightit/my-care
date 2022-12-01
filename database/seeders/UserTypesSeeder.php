<?php

declare(strict_types=1);

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use MyCare\Shared\Domain\User\UserType;
use MyCare\Shared\Domain\User\UserTypeRepositoryInterface;
use MyCare\Shared\Domain\ValueObj\UserTypeEnum;

final class UserTypesSeeder extends Seeder
{
    /**
     * @param  UserTypeRepositoryInterface $repository
     * @return void
     */
    public function run(UserTypeRepositoryInterface $repository): void
    {
        $doctor = $repository->getByName(UserTypeEnum::DOCTOR->name);
        $patient = $repository->getByName(UserTypeEnum::PATIENT->name);
        $admin = $repository->getByName(UserTypeEnum::ADMIN->name);

        if (is_null($admin)) {
            $repository->create(new UserType(UserTypeEnum::ADMIN));
        }
        if (is_null($doctor)) {
            $repository->create(new UserType(UserTypeEnum::DOCTOR));
        }
        if (is_null($patient)) {
            $repository->create(new UserType(UserTypeEnum::PATIENT));
        }
    }
}
