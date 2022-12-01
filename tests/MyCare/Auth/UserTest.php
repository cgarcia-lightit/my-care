<?php

declare(strict_types=1);

namespace Tests\MyCare\Auth;

use Illuminate\Foundation\Testing\DatabaseMigrations;
use MyCare\Auth\Application\Registration;
use MyCare\Auth\Application\VerifierUserEmail;
use MyCare\Shared\Infrastructure\User\UserRepository;
use MyCare\Shared\Infrastructure\User\UserTypeRepository;
use Tests\TestCase;

final class UserTest extends TestCase
{
    use DatabaseMigrations;

    protected function setUp(): void
    {
        parent::setUp();
        $this->artisan('db:seed');
    }

    public function testUserTypeDoctorCanBeCreated()
    {

        $ucase = (new Registration(
            new UserTypeRepository(),
            new UserRepository()
        ))(
            name:"My name and Last Name",
            email: 'saraza@saraza.com',
            password: '123123',
            type: 'DOCTOR'
        );

        $this->assertTrue($ucase->isSuccess(), $ucase->getErrorMessage());
    }

    public function testUserTypePatientCanBeCreated()
    {

        $ucase = (new Registration(
            new UserTypeRepository(),
            new UserRepository()
        ))(
            name:"My name and Last Name",
            email: 'saraza@saraza.com',
            password: '123123',
            type: 'PATIENT'
        );

        $this->assertTrue($ucase->isSuccess(), $ucase->getErrorMessage());
    }

    public function testUserEmailConfirmation()
    {

        $email = 'saraza@saraza.com';
        $password = '123123';

        $ucase = (new Registration(
            new UserTypeRepository(),
            new UserRepository()
        ))(
            name:"My name and Last Name",
            email: $email,
            password: $password,
            type: 'PATIENT'
        );

        $user = $ucase->getData();

        $verifierResponse = (new VerifierUserEmail(new UserRepository()))(
            $user['id']
        );

        $this->assertTrue($verifierResponse->isSuccess(), $verifierResponse->getErrorMessage());
    }
}
