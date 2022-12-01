<?php

declare(strict_types=1);

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use MyCare\Shared\Domain\ValueObj\UserTypeEnum;
use Spatie\Permission\Models\Permission;
use Spatie\Permission\Models\Role;

final class RolesSeeder extends Seeder
{

    public function run(): void
    {
        $allSubmission = Permission::findOrCreate('submissions.*');
        $editSubmission = Permission::findOrCreate('submissions.edit');
        $createSubmission = Permission::findOrCreate('submissions.create');
        $viewSubmissions = Permission::findOrCreate('submissions.view');
        $deleteSubmission = Permission::findOrCreate('submissions.delete');

        /**
         *  We dont assign individually permissions to admin rol see
         *
         *  @see https://spatie.be/docs/laravel-permission/v5/basic-usage/super-admin
         */
        Role::findOrCreate(UserTypeEnum::ADMIN->name);

        $doctorRol = Role::findOrCreate(UserTypeEnum::DOCTOR->name);
        $doctorRol->givePermissionTo($viewSubmissions, $editSubmission);

        $patientRol = Role::findOrCreate(UserTypeEnum::PATIENT->name);
        $patientRol->givePermissionTo(
            $createSubmission,
            $viewSubmissions,
            $deleteSubmission,
            $editSubmission,
        );

    }
}
