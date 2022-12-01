<?php

declare(strict_types=1);

namespace MyCare\Submissions\Application;

use Exception;
use MyCare\Shared\Application\OutDto;
use MyCare\Submissions\Domain\SubmissionRepositoryInterface;

final class SubmissionDeleter
{

    public function __construct(private readonly SubmissionRepositoryInterface $repository)
    {
    }

    /**
     * @param $submissionId
     */
    public function __invoke($submissionId): OutDto
    {
        try {

            $deleted = $this->repository->delete($submissionId);

            return new OutDto($deleted);
        } catch (Exception $exception) {
            return new OutDto(
                code : $exception->getCode(),
                errorMessage: $exception->getMessage()
            );
        }
    }
}
