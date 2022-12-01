<?php

declare(strict_types=1);

namespace MyCare\Submissions\Application;

use Exception;
use MyCare\Shared\Application\OutDto;
use MyCare\Shared\Domain\ValueObj\Identifier;
use MyCare\Submissions\Domain\SubmissionFinder;
use MyCare\Submissions\Domain\SubmissionRepositoryInterface;

final class SubmissionSearchById
{
    private readonly SubmissionFinder $finder;

    public function __construct(
        private readonly SubmissionRepositoryInterface $repository,
    ) {
        $this->finder = new SubmissionFinder($this->repository);
    }

    /**
     * @param $id
     */
    public function __invoke($id): OutDto
    {
        try {
            $submission = $this->finder->__invoke(new Identifier($id));
            return new OutDto($submission);
        } catch (Exception $e) {
            return new OutDto(
                code: $e->getCode(),
                errorMessage: $e->getMessage(),
            );
        }
    }
}
