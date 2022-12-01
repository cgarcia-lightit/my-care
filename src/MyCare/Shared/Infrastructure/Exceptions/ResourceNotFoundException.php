<?php

declare(strict_types=1);

namespace MyCare\Shared\Infrastructure\Exceptions;

use Exception;
use Throwable;

final class ResourceNotFoundException extends Exception
{
    public function __construct(
        string     $message = "Resource not found exception",
        int        $code = 404,
        ?Throwable $previous = null
    ) {
        parent::__construct($message, $code, $previous);
    }
}
