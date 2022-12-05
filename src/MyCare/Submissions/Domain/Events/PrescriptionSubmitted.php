<?php

declare(strict_types=1);

namespace MyCare\Submissions\Domain\Events;

use MyCare\Submissions\Domain\Submission;

final class PrescriptionSubmitted
{
    /**
     * @param Submission $submission
     * @param $file
     */
    public function __construct(public Submission $submission, public mixed $file)
    {
    }
}
