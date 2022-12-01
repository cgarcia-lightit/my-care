<?php

declare(strict_types=1);

namespace App\Providers;

use Illuminate\Foundation\Support\Providers\EventServiceProvider as ServiceProvider;
use MyCare\Shared\Domain\User\Events\CreatedUserEvent;
use MyCare\Shared\Domain\User\Events\PersonalDataUpdatedEvent;
use MyCare\Shared\Domain\User\Listeners\AssignRolesByUserType;
use MyCare\Shared\Domain\User\Listeners\GeneratePersonalInformation;
use MyCare\Shared\Domain\User\Listeners\SendVerificationNotification;
use MyCare\Submissions\Domain\Events\PrescriptionSubmitted;
use MyCare\Submissions\Domain\Events\UploadFileToCloud;

class EventServiceProvider extends ServiceProvider
{
    /**
     * The event to listener mappings for the application.
     *
     * @var array<class-string, array<int, class-string>>
     */
    protected $listen = [
        CreatedUserEvent::class => [
            SendVerificationNotification::class,
            AssignRolesByUserType::class,
            GeneratePersonalInformation::class,
        ],
        PersonalDataUpdatedEvent::class => [

        ]
    ];

    /**
     * Register any events for your application.
     *
     * @return void
     */
    public function boot()
    {
        //
    }

    /**
     * Determine if events and listeners should be automatically discovered.
     *
     * @return bool
     */
    public function shouldDiscoverEvents()
    {
        return false;
    }
}
