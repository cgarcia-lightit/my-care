<?php

declare(strict_types=1);

namespace MyCare\Submissions\Infrastructure;

use App\Http\Controllers\Controller;

;

use Illuminate\Http\Request;
use MyCare\Submissions\Application\SubmissionsPrescriptionFinder;

final class GetSubmissionsPrescriptionsController extends Controller
{

    /**
     * @param SubmissionsPrescriptionFinder $finder
     */
    public function __construct(
        private readonly SubmissionsPrescriptionFinder $finder
    ) {
    }

    /**
     * @param Request $request
     * @param string $submissionId
     * @return mixed
     */
    public function __invoke(
        Request $request,
        string  $submissionId
    ) {
        return $this->finder->__invoke(
            $request->user()->getDomain(),
            $submissionId
        )->getData();
    }
}
