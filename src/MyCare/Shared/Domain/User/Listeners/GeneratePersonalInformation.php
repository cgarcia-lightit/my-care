<?php

declare(strict_types=1);

namespace MyCare\Shared\Domain\User\Listeners;

use MyCare\Shared\Domain\User\Events\CreatedUserEvent;
use MyCare\Shared\Infrastructure\User\Eloquent\EPersonalData;

final class GeneratePersonalInformation
{

    public function __construct()
    {
    }

    public function __invoke(CreatedUserEvent $event)
    {
        $model = EPersonalData::fromDomain($event->user->getPersonalData());
        $model->save();
    }
}
