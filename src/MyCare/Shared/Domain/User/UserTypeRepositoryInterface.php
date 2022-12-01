<?php

declare(strict_types=1);

namespace MyCare\Shared\Domain\User;

interface UserTypeRepositoryInterface
{

    /**
     * @return UserType[]
     */
    public function getAll(): array;

    public function create(UserType $userType): UserType;

    public function getByName(string $name): ?UserType;
}
