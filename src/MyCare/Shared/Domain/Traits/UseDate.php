<?php

declare(strict_types=1);

namespace MyCare\Shared\Domain\Traits;

use DateTime;
use Exception;

trait UseDate
{
    private string $DATE_FORMAT_OUTPUT = 'm/d/y';

    /**
     * @throws Exception
     */
    public function getDateByString(string|DateTime $date): DateTime
    {
        return $date instanceof DateTime ? $date : new DateTime($date);
    }
}
