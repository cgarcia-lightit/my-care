<?php

declare(strict_types=1);

namespace MyCare\Submissions\Application;

use Exception;
use MyCare\Shared\Application\OutDto;
use MyCare\Shared\Domain\User\User;
use MyCare\Shared\Domain\User\UserRepositoryInterface;
use MyCare\Submissions\Domain\SubmissionRepositoryInterface;

final class SubmissionSearcherByUser
{

    public function __construct(
        private readonly SubmissionRepositoryInterface $submissionRepository,
        private readonly UserRepositoryInterface $userRepository
    ) {
    }

    public function __invoke(User $user): OutDto
    {
        try {
            $submissions = $this->submissionRepository->getByUser($user);

            return new OutDto(array_map(fn ($sub) => $sub->toShow(), $submissions));
        } catch (Exception $exception) {
            return new OutDto(
                code: $exception->getCode(),
                errorMessage:  $exception->getMessage(),
            );
        }
    }
}
