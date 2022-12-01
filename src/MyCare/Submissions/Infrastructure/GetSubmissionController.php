<?php

declare(strict_types=1);

namespace MyCare\Submissions\Infrastructure;

use App\Http\Controllers\Controller;
use MyCare\Shared\Infrastructure\WrapperResponder;
use MyCare\Submissions\Application\SubmissionSearchById;
use MyCare\Submissions\Domain\SubmissionRepositoryInterface;

final class GetSubmissionController extends Controller
{
    public function __construct(private readonly SubmissionRepositoryInterface $repository)
    {
    }

    public function __invoke($submissionId)
    {
        $submission = (new SubmissionSearchById($this->repository))($submissionId);

        return WrapperResponder::response($submission);
    }
}
