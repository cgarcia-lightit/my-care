<?php

declare(strict_types=1);

namespace MyCare\Shared\Domain\User\Events;

use MyCare\Shared\Domain\User\User;

final class CreatedUserEvent
{

    public function __construct(public User $user)
    { 
    }

}
