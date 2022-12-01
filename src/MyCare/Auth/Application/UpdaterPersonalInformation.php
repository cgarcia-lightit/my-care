<?php

declare(strict_types=1);

namespace MyCare\Auth\Application;

use Exception;
use MyCare\Shared\Application\OutDto;
use MyCare\Shared\Domain\User\User;
use MyCare\Shared\Domain\User\UserRepositoryInterface;

final class UpdaterPersonalInformation
{

    public function __construct(private readonly UserRepositoryInterface $userRepository)
    {
    }

    public function __invoke(User $user,$contact_phone, $weight, $height, $other_info)
    {
        try {

            $personalInformation = $user->getPersonalData();
            $personalInformation->update($contact_phone, $weight, $height, $other_info);

            $result = $this->userRepository->updatePersonalInformation($personalInformation);

            return new OutDto($result->toArray());
        } catch (Exception $exception) {
            return new OutDto(
                code: $exception->getCode(),
                errorMessage: $exception->getMessage(),
            );
        }
    }
}
