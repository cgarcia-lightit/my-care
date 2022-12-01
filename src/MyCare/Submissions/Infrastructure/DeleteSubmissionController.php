<?php

declare(strict_types=1);

namespace MyCare\Submissions\Infrastructure;

use App\Http\Controllers\Controller;
use MyCare\Shared\Infrastructure\WrapperResponder;
use MyCare\Submissions\Application\SubmissionDeleter;
use MyCare\Submissions\Domain\SubmissionRepositoryInterface;

final class DeleteSubmissionController extends Controller
{
    public function __construct(private readonly SubmissionRepositoryInterface $repository)
    {
    }

    public function __invoke($submissionId)
    {
        $deleted = (new SubmissionDeleter($this->repository))(
            submissionId : $submissionId
        );

        return WrapperResponder::response($deleted);
    }
}
