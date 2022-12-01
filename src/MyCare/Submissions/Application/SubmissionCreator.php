<?php

declare(strict_types=1);

namespace MyCare\Submissions\Application;

use Exception;
use MyCare\Shared\Application\OutDto;
use MyCare\Shared\Domain\User\User;
use MyCare\Shared\Domain\ValueObj\Identifier;
use MyCare\Submissions\Domain\Submission;
use MyCare\Submissions\Domain\SubmissionRepositoryInterface;
use MyCare\Submissions\Domain\ValueObj\SubmissionStatus;

final class SubmissionCreator
{

    public function __construct(
        private readonly SubmissionRepositoryInterface $repository,
        private readonly User                          $user
    ) {
    }

    /**
     * @param  $title
     * @param  $symptoms
     * @return OutDto
     */
    public function __invoke($title, $symptoms): OutDto
    {
        try {

            $submission = $this->repository->save(
                new Submission(
                    id: new Identifier(),
                    title: $title,
                    symptoms: $symptoms,
                    status: SubmissionStatus::PENDING,
                    patient: $this->user,
                )
            );

            if (!($submission instanceof Submission)) {
                throw new Exception('The submission could not be saved');
            }

            return new OutDto($submission);
        } catch (Exception $exception) {
            return new OutDto(null, $exception->getCode(), $exception->getMessage());
        }
    }
}
