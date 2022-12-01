<?php

declare(strict_types=1);

namespace MyCare\Auth\Infrastructure;

use App\Http\Controllers\Controller;
use App\Http\Requests\VerifyUserEmailRequest;
use MyCare\Auth\Application\VerifierUserEmail;
use MyCare\Shared\Domain\User\UserRepositoryInterface;
use MyCare\Shared\Infrastructure\WrapperResponder;

final class VerifyEmailController extends Controller
{
    public function __construct(private readonly UserRepositoryInterface $repository)
    {

    }

    public function __invoke(VerifyUserEmailRequest $request)
    {
        $verifierResponse = (new VerifierUserEmail($this->repository))(
            $request->get('id')
        );

        return WrapperResponder::response($verifierResponse);
    }
}
