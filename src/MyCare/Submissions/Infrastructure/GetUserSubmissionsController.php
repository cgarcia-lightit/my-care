<?php

declare(strict_types=1);

namespace MyCare\Submissions\Infrastructure;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use MyCare\Shared\Infrastructure\User\Eloquent\User;
use MyCare\Shared\Infrastructure\WrapperResponder;
use MyCare\Submissions\Application\SubmissionSearcherByUser;

final class GetUserSubmissionsController extends Controller
{
    public function __construct(
        private readonly SubmissionSearcherByUser $searcher,
    ) {
    }

    public function __invoke(Request $request)
    {
        $result = $this->searcher->__invoke(
            $request->user()->getDomain()
        );

        return WrapperResponder::response($result);
    }

}
