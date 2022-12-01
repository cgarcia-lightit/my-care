<?php

declare(strict_types=1);

namespace MyCare\Submissions\Infrastructure;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use MyCare\Shared\Infrastructure\WrapperResponder;
use MyCare\Submissions\Application\SubmissionSearcher;
use MyCare\Submissions\Domain\SubmissionRepositoryInterface;

final class GetSubmissionsController extends Controller
{
    public function __construct(
        private readonly SubmissionSearcher $ucase
    ) {
    }

    public function __invoke(Request $request)
    {
        $submissions = $this->ucase->__invoke(
            limit: (int) $request->get('limit', 100),
            offset: (int) $request->get('offset', 0),
        );

        return WrapperResponder::response($submissions);
    }
}
