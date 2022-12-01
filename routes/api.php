<?php

declare(strict_types=1);

use Illuminate\Support\Facades\Route;
use MyCare\Auth\Infrastructure\GetUserInformationController;
use MyCare\Auth\Infrastructure\LoginController;
use MyCare\Auth\Infrastructure\LogoutController;
use MyCare\Auth\Infrastructure\RegisterController;
use MyCare\Auth\Infrastructure\UpdatePersonalInformationController;
use MyCare\Auth\Infrastructure\VerifyEmailController;
use MyCare\Submissions\Infrastructure\GetAllUsersTypesController;

/*
|--------------------------------------------------------------------------
| API Routes
|--------------------------------------------------------------------------
|
| Here is where you can register API routes for your application. These
| routes are loaded by the RouteServiceProvider within a group which
| is assigned the "api" middleware group. Enjoy building your API!
|
*/

Route::middleware(['auth:sanctum'])->group(
    function () {
        Route::get('/user', GetUserInformationController::class)->name('get-user-information');
        Route::post('/user', UpdatePersonalInformationController::class)->name('edit-user-information');

        Route::get('/users-types', GetAllUsersTypesController::class)->name('users-types');
    }
);

Route::post('/logout', LogoutController::class)->name('logout');
Route::post('/login', LoginController::class)->name('login');

Route::post('/register', RegisterController::class)->name('register');
Route::get('/email/verify', VerifyEmailController::class)->name('mail-verify');
