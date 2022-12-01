<?php

declare(strict_types=1);

namespace MyCare\Submissions\Domain\ValueObj;

enum SubmissionStatus: string
{
    case PENDING = 'PENDING';
    case IN_PROGRESS = 'IN_PROGRESS';
    case DONE = 'DONE';

    const TRANSITIONS = [
        'PENDING' => [
            self::IN_PROGRESS,
            self::DONE
        ],
        'IN_PROGRESS' => [
            self::DONE
        ],
        'DONE' => []
    ];

    public function canProceedTo(SubmissionStatus $status): bool
    {
        return in_array($status, self::TRANSITIONS[$this->value]);
    }
}
