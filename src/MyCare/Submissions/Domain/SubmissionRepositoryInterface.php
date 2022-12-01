<?php

declare(strict_types=1);

namespace MyCare\Submissions\Domain;

use MyCare\Shared\Domain\User\User;
use MyCare\Shared\Domain\ValueObj\Identifier;

interface SubmissionRepositoryInterface
{
    /**
     * @param  Submission $submission
     * @return Submission
     */
    public function save(Submission $submission): Submission;

    /**
     * @param  Submission $submission
     * @return Submission
     */
    public function create(Submission $submission): Submission;

    /**
     * @param  Identifier $identifier
     * @return Submission|null
     */
    public function find(Identifier $identifier):?Submission;

    /**
     * @return Submission[]
     */
    public function searchPendingSubmissions(array $params = []): array;

    /**
     * @param $submissionId
     */
    public function delete($submissionId) : bool;

    /**
     * @return Submission[]
     */
    public function getByUser(User $user): array;

    /**
     * @return Submission[]
     */
    public function getByDoctor(User $user): array;


}
