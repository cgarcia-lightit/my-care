<?php

declare(strict_types=1);

namespace MyCare\Submissions\Application;

use Exception;
use Illuminate\Support\Facades\Log;
use MyCare\Shared\Application\OutDto;
use MyCare\Shared\Domain\User\User;
use MyCare\Shared\Domain\User\UserRepositoryInterface;
use MyCare\Submissions\Domain\Submission;
use MyCare\Submissions\Domain\SubmissionRepositoryInterface;

final class SubmissionSearcher
{

    public function __construct(
        private readonly SubmissionRepositoryInterface $repository,
        private readonly UserRepositoryInterface $userRepository
    ) {
    }

    public function __invoke(int $limit = 100, int $offset = 0): OutDto
    {
        try {
            $params = [
                'limit' => $limit,
                'offset' => $offset,
            ];

            $submissions = $this->repository->searchPendingSubmissions($params);

            return new OutDto(array_map(fn ($sub) => $sub->toShow(), $submissions));
        } catch (Exception $e) {
            return new OutDto(
                code: $e->getCode(),
                errorMessage: $e->getMessage()
            );
        }
    }
}
