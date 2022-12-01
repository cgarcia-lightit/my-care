<?php

declare(strict_types=1);

namespace MyCare\Shared\Domain\User;

interface UserRolesRepositoryInterface
{
    /**
     * Assign a rol to an user
     */
    public function assignRole(User $user, string $rol): bool;
}
