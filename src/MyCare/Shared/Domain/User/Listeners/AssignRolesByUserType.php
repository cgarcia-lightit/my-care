<?php

declare(strict_types=1);

namespace MyCare\Shared\Domain\User\Listeners;

use MyCare\Shared\Domain\User\Events\CreatedUserEvent;
use MyCare\Shared\Domain\User\UserRolesRepositoryInterface;
use MyCare\Shared\Domain\ValueObj\UserTypeEnum;

final class AssignRolesByUserType
{

    public function __construct(private readonly UserRolesRepositoryInterface $repository)
    {
    }

    public function __invoke(CreatedUserEvent $event): void
    {
        $user = $event->user;
        $this->repository->assignRole(
            $user,
            UserTypeEnum::from($user->getTypeId())->name
        );
    }
}
