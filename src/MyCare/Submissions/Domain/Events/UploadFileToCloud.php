<?php

declare(strict_types=1);

namespace MyCare\Submissions\Domain\Events;

use Exception;
use Illuminate\Support\Facades\Storage;
use MyCare\Submissions\Domain\SubmissionFinder;
use MyCare\Submissions\Domain\SubmissionRepositoryInterface;

final class UploadFileToCloud
{
    public function __invoke(PrescriptionSubmitted $event): void
    {
        Storage::put($event->submission->getPrescriptions(), $event->file->getContent());
    }
}
