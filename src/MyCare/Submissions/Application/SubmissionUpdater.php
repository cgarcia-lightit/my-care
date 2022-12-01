<?php

declare(strict_types=1);

namespace MyCare\Submissions\Application;

use Exception;
use MyCare\Shared\Application\OutDto;
use MyCare\Shared\Domain\User\User;
use MyCare\Shared\Domain\ValueObj\Identifier;
use MyCare\Shared\Infrastructure\Exceptions\ResourceNotFoundException;
use MyCare\Submissions\Domain\SubmissionFinder;
use MyCare\Submissions\Domain\SubmissionRepositoryInterface;
use MyCare\Submissions\Domain\ValueObj\SubmissionStatus;

final class SubmissionUpdater
{
    private readonly SubmissionFinder $submissionFinder;

    public function __construct(
        private readonly SubmissionRepositoryInterface $repository,
        private readonly User $user
    ) {
        $this->submissionFinder = new SubmissionFinder($repository);
    }

    /**
     * @param  $id
     * @param  $data
     * @return OutDto
     */
    public function __invoke($id, $data): OutDto
    {
        try {

            $submission = $this->submissionFinder->__invoke(new Identifier($id));

            if (!$submission) {
                throw new ResourceNotFoundException('Submission not found');
            }

            if (isset($data['status'])) {
                $submission->updateStatus(SubmissionStatus::from($data['status']));
            }

            $submission->setDoctor($this->user);

            if (isset($data['prescriptions']) && $submission->canAttachPrescription()) {
                $submission->attachPrescription($data['prescriptions']);
            }

            $this->repository->save($submission);

            $successCode = 200;
            if ($submission->hasUnreadEvents()) {
                $events = $submission->pullEvents();
                foreach ($events as $event ) {
                    event($event);
                }

                $successCode = 202;
            }

            return new OutDto(
                data:  $submission,
                code: $successCode,
            );

        } catch (Exception $e) {
            return new OutDto(code: $e->getCode(), errorMessage: $e->getMessage());
        }
    }
}
