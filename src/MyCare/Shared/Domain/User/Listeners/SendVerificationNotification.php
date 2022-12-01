<?php

declare(strict_types=1);

namespace MyCare\Shared\Domain\User\Listeners;

use App\Notifications\EmailConfirmationNotification;
use Illuminate\Support\Facades\Notification;
use MyCare\Shared\Domain\User\Events\CreatedUserEvent;

final class SendVerificationNotification
{
    public function __invoke(CreatedUserEvent $event): void
    {
        $user = $event->user;
        Notification::send($user, new EmailConfirmationNotification());
    }
}
