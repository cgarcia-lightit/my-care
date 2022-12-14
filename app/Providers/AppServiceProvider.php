<?php

declare(strict_types=1);

namespace App\Providers;

use Illuminate\Http\File;
use Illuminate\Support\ServiceProvider;
use MyCare\Shared\Domain\User\UserRepositoryInterface;
use MyCare\Shared\Domain\User\UserRolesRepositoryInterface;
use MyCare\Shared\Domain\User\UserTypeRepositoryInterface;
use MyCare\Shared\Infrastructure\FileStore;
use MyCare\Shared\Infrastructure\Response\LaravelResponder;
use MyCare\Shared\Infrastructure\Response\ResponseInterface;
use MyCare\Shared\Infrastructure\StorageInterface;
use MyCare\Shared\Infrastructure\User\UserRepository;
use MyCare\Shared\Infrastructure\User\UserRoleRepository;
use MyCare\Shared\Infrastructure\User\UserTypeRepository;
use MyCare\Submissions\Domain\SubmissionRepositoryInterface;
use MyCare\Submissions\Infrastructure\SubmissionRepository;

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
        $this->app->bind(SubmissionRepositoryInterface::class, SubmissionRepository::class);
        $this->app->bind(StorageInterface::class, FileStore::class);
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
