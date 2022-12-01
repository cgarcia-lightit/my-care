<?php

declare(strict_types=1);

namespace MyCare\Auth\Application;

use Exception;
use MyCare\Shared\Application\OutDto;
use MyCare\Shared\Domain\User\UserRepositoryInterface;

final class VerifierUserEmail
{

    public function __construct(private readonly UserRepositoryInterface $userRepository)
    {
    }

    public function __invoke(string $id): OutDto
    {
        try {

            $user = $this->userRepository->findById($id);
            $user->verifyEmail();

            $this->userRepository->update($user);

            return new OutDto(code: 204);

        } catch (Exception $exception) {
            return new OutDto(
                code: $exception->getCode(),
                errorMessage: $exception->getMessage(),
            );
        }
    }
}
