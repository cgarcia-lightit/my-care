<?php

declare(strict_types=1);

namespace MyCare\Shared\Application;

use Exception;
use MyCare\Shared\Domain\User\UserTypeRepositoryInterface;

final class SearchUsersTypes
{
    public function __construct(private readonly UserTypeRepositoryInterface $repository)
    {
    }

    public function __invoke(): OutDto
    {
        try {
            $types = $this->repository->getAll();
            return new OutDto($types);
        } catch (Exception $exception) {
            return new OutDto(
                code: $exception->getCode(),
                errorMessage: $exception->getMessage()
            );
        }
    }
}
