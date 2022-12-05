<?php

declare(strict_types=1);

use Illuminate\Support\Facades\Route;
use MyCare\Auth\Infrastructure\GetUserInformationController;
use MyCare\Auth\Infrastructure\LoginController;
use MyCare\Auth\Infrastructure\LogoutController;
use MyCare\Auth\Infrastructure\RegisterController;
use MyCare\Auth\Infrastructure\UpdatePersonalInformationController;
use MyCare\Auth\Infrastructure\VerifyEmailController;
use MyCare\Submissions\Infrastructure\CreateSubmissionController;
use MyCare\Submissions\Infrastructure\DeleteSubmissionController;
use MyCare\Submissions\Infrastructure\GetAllUsersTypesController;
use MyCare\Submissions\Infrastructure\GetDoctorSubmissionsController;
use MyCare\Submissions\Infrastructure\GetSubmissionController;
use MyCare\Submissions\Infrastructure\GetSubmissionsController;
use MyCare\Submissions\Infrastructure\GetSubmissionsPrescriptionsController;
use MyCare\Submissions\Infrastructure\GetUserSubmissionsController;
use MyCare\Submissions\Infrastructure\UpdateSubmissionController;

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
        Route::get('/user/{id}/submissions', GetUserSubmissionsController::class)->name('get-user-submissions');
        Route::get('/doctor/{id}/submissions', GetDoctorSubmissionsController::class)->name('get-doctor-submissions');
        Route::group(
            ['prefix' => '/submissions'], function () {
                Route::get('/', GetSubmissionsController::class)
                    ->name('get-submissions')
                    ->middleware(['can:submissions.view']);

                Route::get('/{submission_id}/prescriptions', GetSubmissionsPrescriptionsController::class)
                    ->name('get-submission-prescriptions')
                    ->middleware(['can:submissions.view']);

                Route::get('/{submission_id}', GetSubmissionController::class)
                    ->name('get-submission')
                    ->middleware(['can:submissions.view']);

                Route::post('/', CreateSubmissionController::class)
                    ->name('create-submission')
                    ->middleware(['can:submissions.create']);

                Route::put('/{submission_id}', UpdateSubmissionController::class)
                    ->name('edit-submission')
                    ->middleware(['can:submissions.edit']);

                Route::delete('/{submission_id}', DeleteSubmissionController::class)
                    ->name('delete-submission')
                    ->middleware(['can:submissions.delete']);
            }
        );
    }
);

Route::post('/logout', LogoutController::class)->name('logout');
Route::post('/login', LoginController::class)->name('login');

Route::post('/register', RegisterController::class)->name('register');
Route::get('/email/verify', VerifyEmailController::class)->name('mail-verify');
