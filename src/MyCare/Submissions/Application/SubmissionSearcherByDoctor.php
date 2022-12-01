<?php

declare(strict_types=1);

namespace MyCare\Submissions\Application;

use Exception;
use MyCare\Shared\Application\OutDto;
use MyCare\Shared\Domain\User\User;
use MyCare\Submissions\Domain\SubmissionRepositoryInterface;

final class SubmissionSearcherByDoctor
{
    public function __construct(
        private readonly SubmissionRepositoryInterface $submissionRepository
    ) {
    }

    public function __invoke(User $doctor): OutDto
    {
        try {
            $submissions = $this->submissionRepository->getByDoctor($doctor);

            return new OutDto(array_map(fn($sub) => $sub->toShow(), $submissions));
        } catch (Exception $exception) {
            return new OutDto(
                code: $exception->getCode(),
                errorMessage: $exception->getMessage(),
            );
        }
    }
}
