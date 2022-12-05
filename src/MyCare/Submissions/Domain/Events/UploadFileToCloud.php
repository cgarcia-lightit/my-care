<?php

declare(strict_types=1);

namespace MyCare\Submissions\Domain\Events;

use Exception;
use Illuminate\Support\Facades\Storage;
use MyCare\Shared\Infrastructure\StorageInterface;
use MyCare\Submissions\Domain\SubmissionFinder;
use MyCare\Submissions\Domain\SubmissionRepositoryInterface;

final class UploadFileToCloud
{
    public function __construct(
        private readonly SubmissionRepositoryInterface $repository,
        private readonly StorageInterface $store
    ) {
    }

    public function __invoke(
        PrescriptionSubmitted $event
    ): void {
        $this->store->put(
            $event->submission->getPathPrescription(),
            $event->file->getContent()
        );
        $event->submission->setPrescriptions(
            url("/api/submissions/{$event->submission->getId()}/prescriptions")
        );
        $event->submission->setUpdatedAt('now');
        $this->repository->save($event->submission);
    }
}
