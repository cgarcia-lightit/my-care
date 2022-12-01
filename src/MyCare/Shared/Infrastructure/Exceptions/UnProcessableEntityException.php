<?php

declare(strict_types=1);

namespace MyCare\Shared\Infrastructure\Exceptions;

use Exception;
use Throwable;

final class UnProcessableEntityException extends Exception
{

    public function __construct(
        string $message = "",
        int $code = 422,
        ?Throwable $previous = null
    ) {
        parent::__construct($message, $code, $previous);
    }
}
