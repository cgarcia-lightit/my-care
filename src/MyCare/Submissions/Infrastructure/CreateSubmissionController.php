<?php

declare(strict_types=1);

namespace MyCare\Submissions\Infrastructure;

use App\Http\Controllers\Controller;
use App\Http\Requests\PostSubmissionRequest;
use Exception;
use Illuminate\Support\Facades\Auth;
use MyCare\Shared\Infrastructure\User\Eloquent\User;
use MyCare\Shared\Infrastructure\WrapperResponder;
use MyCare\Submissions\Application\SubmissionCreator;
use MyCare\Submissions\Domain\SubmissionRepositoryInterface;

final class CreateSubmissionController extends Controller
{
    public function __construct(private readonly SubmissionRepositoryInterface $repository)
    {
    }

    /**
     * @throws Exception
     */
    public function __invoke(PostSubmissionRequest $request)
    {
        $creatorResult = (new SubmissionCreator($this->repository, $request->user()->getDomain()))(
            title: $request->title,
            symptoms : $request->symptoms,
        );

        return WrapperResponder::response($creatorResult);
    }
}
