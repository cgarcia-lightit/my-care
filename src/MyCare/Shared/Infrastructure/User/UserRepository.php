<?php

declare(strict_types=1);

namespace MyCare\Shared\Infrastructure\User;

use Exception;
use MyCare\Shared\Domain\User\PersonalData;
use MyCare\Shared\Domain\User\User;
use MyCare\Shared\Domain\User\UserRepositoryInterface;
use MyCare\Shared\Infrastructure\User\Eloquent\EPersonalData;
use MyCare\Shared\Infrastructure\User\Eloquent\User as EUser;

final class UserRepository implements UserRepositoryInterface
{
    public function create(User $user): User
    {
        $emodel = EUser::createByDomain($user);
        $emodel->save();

        return $user;
    }

    /**
     * @throws Exception
     */
    public function update(User $user): User
    {
        /**
         * @var EUser $emodel
         */
        $emodel = EUser::where('id', $user->getId())
            ->updateUsingDomain($user);
        $user->setUpdatedAt('now');
        return $user;
    }

    /**
     * @throws Exception
     */
    public function findById(string $userId): ?User
    {
        /**
         * @var EUser $user
         */
        $user = EUser::find($userId);
        return $user?->getDomain();
    }

    public function findByEmail(string $userEmail): ?User
    {
        return EUser::where('email', $userEmail)->first()?->getDomain();
    }

    /**
     * @return array|User[]
     * @throws Exception
     */
    public function findByIds(array $ids): array
    {
        return EUser::whereIn('id', $ids)
            ->get()
            ->map(fn(EUser $user) => $user->getDomain());
    }

    public function updatePersonalInformation(PersonalData $personalData): PersonalData
    {
        EPersonalData::where('id', $personalData->getId())
            ->updateUsingDomain($personalData);
        return $personalData;
    }


}
