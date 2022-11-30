<?php

declare(strict_types=1);

namespace MyCare\Shared\Infrastructure;

use Illuminate\Support\Facades\App;
use MyCare\Shared\Application\OutDto;
use MyCare\Shared\Infrastructure\Response\ResponseInterface;

final class WrapperResponder
{

    public static function response(OutDto $result)
    {
        /** @var ResponseInterface::class $res */
        $res = App::make(ResponseInterface::class);
        return $res->response($result);
    }
}
