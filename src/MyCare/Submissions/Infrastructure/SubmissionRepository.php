<?php

declare(strict_types=1);

namespace MyCare\Submissions\Infrastructure;

use Exception;
use MyCare\Shared\Domain\User\User;
use MyCare\Shared\Domain\ValueObj\Identifier;
use MyCare\Submissions\Domain\Submission;
use MyCare\Submissions\Domain\SubmissionRepositoryInterface;
use MyCare\Submissions\Infrastructure\Eloquent\ESubmission;

final class SubmissionRepository implements SubmissionRepositoryInterface
{
    /**
     * @throws Exception
     */
    public function create(Submission $submission): Submission
    {
        ESubmission::query()->createUsingDomain($submission);
        return $submission;
    }

    /**
     * @throws Exception
     */
    public function save(Submission $submission): Submission
    {
        ESubmission::query()->updateUsingDomain($submission);
        return $submission;
    }

    public function find(Identifier $identifier): ?Submission
    {
        $submissionModel = ESubmission::find($identifier->get());
        return $submissionModel?->getDomain();
    }

    /**
     * @return array|Submission[]
     */
    public function searchPendingSubmissions(array $params = []): array
    {
        $query =  ESubmission::query();
        if (isset($params['patient_id'])) {
            $query->where('patient_id', '=', $params['patient_id']);
        }
        if (isset($params['doctor_id'])) {
            $query->where('doctor_id', '=', $params['doctor_id']);
        }

        if (isset($params['limit'])) {
            $query->limit($params['limit']);
        }

        if (isset($params['offset'])) {
            $query->offset($params['offset']);
        }

        return $query->where('status', 'PENDING')
            ->with('patient')
            ->orderBy('created_at', 'desc')
            ->get()
            ->map(fn (ESubmission $submission) =>  $submission->getDomain())
            ->toArray();
    }

    /**
     * @param  $submissionId
     * @return bool
     */
    public function delete($submissionId): bool
    {
        return (bool) ESubmission::where('id', $submissionId)->delete();
    }

    /**
     * @return array|Submission[]
     * @throws Exception
     */
    public function getByUser(User $user): array
    {
        return ESubmission::where('patient_id', $user->getId())
            ->orderBy('created_at', 'desc')
            ->get()
            ->map(fn (ESubmission $submission) => $submission->getDomain())
            ->toArray();
    }

    public function getByDoctor(User $user): array
    {
        return ESubmission::where('doctor_id', $user->getId())
            ->orderBy('created_at', 'desc')
            ->get()
            ->map(fn (ESubmission $submission) => $submission->getDomain())
            ->toArray();
    }


}
