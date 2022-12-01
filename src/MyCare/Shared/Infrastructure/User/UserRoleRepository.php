<?php

declare(strict_types=1);

namespace MyCare\Shared\Infrastructure\User;

use MyCare\Shared\Domain\User\User;
use MyCare\Shared\Domain\User\UserRolesRepositoryInterface;
use MyCare\Shared\Infrastructure\User\Eloquent\User as EUser;

final class UserRoleRepository implements UserRolesRepositoryInterface
{
    public function assignRole(User $user, string $rol): bool
    {
        /**
         * @var EUser $euser
         */
        $euser = EUser::find($user->getId());
        $euser->assignRole($user->getTypeId());
        return true;
    }
}
