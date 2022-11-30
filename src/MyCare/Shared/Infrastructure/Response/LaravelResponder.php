<?php

declare(strict_types=1);

namespace MyCare\Shared\Infrastructure\Response;


use Illuminate\Http\JsonResponse;
use MyCare\Shared\Application\OutDto;
use MyCare\Shared\Domain\Domain;

final class LaravelResponder implements ResponseInterface
{
    public function response(OutDto $dto): JsonResponse
    {
        $responder = responder();

        $code = $dto->getCode();

        $httpCode = $code >= 600 || $code === 0 ? 500 : $code;
        $response = $dto->getData();

        $data =  $response instanceof Domain ?
            $response->toShow() :
            (
            (is_array($response) || is_string($response)) ?
                    $response :
                    json_encode($response)
            );
        return $dto->isSuccess() ?
            $responder->success($data)->respond($httpCode) :
            $responder->error($code, $dto->getErrorMessage())->respond($httpCode);
    }


}
