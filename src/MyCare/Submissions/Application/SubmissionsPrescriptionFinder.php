<?php

declare(strict_types=1);

namespace MyCare\Submissions\Application;

use Exception;
use MyCare\Shared\Application\OutDto;
use MyCare\Shared\Domain\User\User;
use MyCare\Shared\Domain\ValueObj\Identifier;
use MyCare\Shared\Infrastructure\StorageInterface;
use MyCare\Submissions\Domain\Submission;
use MyCare\Submissions\Domain\SubmissionRepositoryInterface;

final class SubmissionsPrescriptionFinder
{
    public function __construct(
        private readonly StorageInterface $storage,
        private readonly SubmissionRepositoryInterface $repo
    ) {
    }

    public function __invoke(User $user, string $submissionId)
    {
        try {

            $submission = $this->repo->find(new Identifier($submissionId));

            if (!$submission->userCanReadPrescription($user)) {
                throw new Exception('forbidden', 403);
            }

            $file = $this->storage->download($submission->getPathPrescription());

            return new OutDto(
                data: $file
            );
        } catch (Exception $exception) {
            return new OutDto(
                code: $exception->getCode(),
                errorMessage: $exception->getMessage()
            );
        }
    }
}
