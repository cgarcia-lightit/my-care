<?php

declare(strict_types=1);

namespace MyCare\Shared\Infrastructure\User;

use Exception;
use MyCare\Shared\Domain\User\UserType;
use MyCare\Shared\Domain\User\UserTypeRepositoryInterface;
use MyCare\Shared\Infrastructure\User\Eloquent\EUserType;

final class UserTypeRepository implements UserTypeRepositoryInterface
{
    /**
     * @return array|UserType[]
     * @throws Exception
     */
    public function getAll(): array
    {
        $types = EUserType::all();
        return EUserType::mapEtypesToDomain($types);
    }

    public function create(UserType $userType): UserType
    {
        $emodel = new EUserType(
            [
                'id' => $userType->getId(),
                'created_at' => $userType->getCreatedAt(),
                'updated_at' => $userType->getUpdatedAt(),
            ]
        );
        $emodel->save();
        return $emodel->getModel();
    }

    /**
     * @throws Exception
     */
    public function getByName(string $name): ?UserType
    {
        /**
         * @var EUserType $emodel
         */
        $emodel = EUserType::find($name);
        return $emodel?->getModel();
    }

}
