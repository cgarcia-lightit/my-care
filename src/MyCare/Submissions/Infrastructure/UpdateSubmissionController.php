<?php

declare(strict_types=1);

namespace MyCare\Submissions\Infrastructure;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use MyCare\Shared\Infrastructure\User\Eloquent\User;
use MyCare\Shared\Infrastructure\WrapperResponder;
use MyCare\Submissions\Application\SubmissionUpdater;
use MyCare\Submissions\Domain\SubmissionRepositoryInterface;

final class UpdateSubmissionController extends Controller
{
    public function __construct(private readonly SubmissionRepositoryInterface $repository)
    {
    }

    public function __invoke(Request $request, $submissionId)
    {
        $data = $request->only(['status']);

        if ($request->hasFile('prescriptions')) {
            $data['prescriptions'] = $request->file('prescriptions');
        }

        $submission = (new SubmissionUpdater($this->repository, $request->user()->getDomain()))(
            id: $submissionId,
            data: $data
        );

        return WrapperResponder::response($submission);
    }
}
