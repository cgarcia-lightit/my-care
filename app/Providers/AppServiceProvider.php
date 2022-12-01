<?php

declare(strict_types=1);

namespace App\Providers;

use Illuminate\Support\ServiceProvider;
use MyCare\Shared\Domain\User\UserRepositoryInterface;
use MyCare\Shared\Domain\User\UserRolesRepositoryInterface;
use MyCare\Shared\Domain\User\UserTypeRepositoryInterface;
use MyCare\Shared\Infrastructure\Response\LaravelResponder;
use MyCare\Shared\Infrastructure\Response\ResponseInterface;
use MyCare\Shared\Infrastructure\User\UserRepository;
use MyCare\Shared\Infrastructure\User\UserRoleRepository;
use MyCare\Shared\Infrastructure\User\UserTypeRepository;

class AppServiceProvider extends ServiceProvider
{
    /**
     * Register any application services.
     *
     * @return void
     */
    public function register()
    {
        $this->app->bind(ResponseInterface::class, LaravelResponder::class);
        $this->app->bind(UserTypeRepositoryInterface::class, UserTypeRepository::class);
        $this->app->bind(UserRepositoryInterface::class, UserRepository::class);
        $this->app->bind(UserRolesRepositoryInterface::class, UserRoleRepository::class);
    }

    /**
     * Bootstrap any application services.
     *
     * @return void
     */
    public function boot()
    {
        //
    }
}
