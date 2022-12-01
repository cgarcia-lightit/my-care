<?php

declare(strict_types=1);

namespace MyCare\Shared\Domain\User\Events;

use MyCare\Shared\Domain\User\PersonalData;

final class PersonalDataUpdatedEvent
{

    public function __construct(public PersonalData $data)
    {
    }
}
