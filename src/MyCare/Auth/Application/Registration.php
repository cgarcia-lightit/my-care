<?php

declare(strict_types=1);

namespace MyCare\Auth\Application;

use Exception;
use MyCare\Shared\Application\OutDto;
use MyCare\Shared\Domain\User\User;
use MyCare\Shared\Domain\User\UserType;
use MyCare\Shared\Domain\User\UserTypeRepositoryInterface;
use MyCare\Shared\Domain\ValueObj\UserTypeEnum;
use MyCare\Shared\Infrastructure\Exceptions\UnProcessableEntityException;
use MyCare\Shared\Infrastructure\User\UserRepository;

final class Registration
{

    public function __construct(
        private readonly UserTypeRepositoryInterface $userTypeRepository,
        private readonly UserRepository              $userRepository
    ) {

    }

    public function __invoke(
        string $name,
        string $email,
        string $password,
        string $type
    ): OutDto {
        try {

            $userType = $this->userTypeRepository->getByName($type);

            if (!$userType instanceof UserType) {
                throw new UnProcessableEntityException('User type not found');
            }

            $user = $this->userRepository->findByEmail($email);

            if (!empty($user)) {
                throw new Exception('Email has already been taken', 422);
            }

            $type = UserTypeEnum::from($type);

            if ($type == UserTypeEnum::ADMIN) {
                throw new Exception('user type is not valid', 403);
            }

            $user = User::create(
                name: $name,
                email: $email,
                type_id: $type,
                password: $password,
            );

            $this->userRepository->create($user);

            $events = $user->pullEvents();
            foreach ($events as $event) {
                event($event);
            }

            return new OutDto($user->toShow());
        } catch (Exception $exception) {

            return new OutDto(
                code: $exception->getCode(),
                errorMessage: $exception->getMessage()
            );
        }
    }

}
