<?php

declare(strict_types=1);

namespace MyCare\Shared\Infrastructure\Response;

use MyCare\Shared\Application\OutDto;

interface ResponseInterface
{
    public function response(OutDto $dto);
}
