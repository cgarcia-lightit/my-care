<?php

declare(strict_types=1);

namespace MyCare\Submissions\Domain;

use Exception;
use MyCare\Shared\Domain\ValueObj\Identifier;
use MyCare\Submissions\Infrastructure\Eloquent\ESubmission;

final class SubmissionFinder
{

    public function __construct(private readonly SubmissionRepositoryInterface $repository)
    {
    }

    /**
     * @throws Exception
     */
    public function __invoke(Identifier $id): ?Submission
    {
        $submission = $this->repository->find($id);

        if (!$submission) {
            throw new Exception("Submission $id not found.");
        }

        return $submission;
    }
}
