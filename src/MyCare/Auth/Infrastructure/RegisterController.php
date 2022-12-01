<?php

declare(strict_types=1);

namespace MyCare\Auth\Infrastructure;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use MyCare\Auth\Application\Registration;
use MyCare\Shared\Domain\User\UserRepositoryInterface;
use MyCare\Shared\Domain\User\UserTypeRepositoryInterface;
use MyCare\Shared\Infrastructure\WrapperResponder;

final class RegisterController extends Controller
{

    public function __construct(
        private readonly UserTypeRepositoryInterface $userTypeRepository,
        private readonly UserRepositoryInterface $userRepository
    ) {
    }

    public function __invoke(Request $request)
    {
        $register = (new Registration(
            $this->userTypeRepository,
            $this->userRepository
        ))(
            name: $request->get('name'),
            email: $request->get('email'),
            password: $request->get('password'),
            type: $request->get('user_type')
        );
        return WrapperResponder::response($register);
    }
}
