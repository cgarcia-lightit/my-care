<?php

declare(strict_types=1);

namespace MyCare\Shared\Infrastructure\Response;


use Illuminate\Http\JsonResponse;
use JetBrains\PhpStorm\NoReturn;
use MyCare\Shared\Application\OutDto;
use MyCare\Shared\Domain\Domain;

final class LaravelResponder implements ResponseInterface
{
    public function response(OutDto $dto)
    {
        $response = $dto->getData();
        $data = $response instanceof Domain ?
            $response->toShow() :
            (
            (is_array($response) || is_string($response)) ?
                $response :
                json_encode($response)
            );

        $code = $dto->getCode();
        $httpCode = $code >= 600 || $code === 0 ? 500 :
            (empty($data) ? 204 : $code);

        $httpCode = empty($data) ? 204 : $httpCode;

        if (empty($data) || $httpCode === 204) {
            // For some reason if $data is empty and status code is 204 fractal generate a unexpected error
            return responder()->success()->respond(204);
        }

        return $dto->isSuccess() ?
            responder()->success(
                data: $data
            )->respond(
                status: $httpCode
            ) :
            responder()->error(
                errorCode: $code,
                message: $dto->getErrorMessage()
            )->respond($httpCode);
    }


}
