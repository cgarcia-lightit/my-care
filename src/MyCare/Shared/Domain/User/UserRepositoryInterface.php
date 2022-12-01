<?php

declare(strict_types=1);

namespace MyCare\Shared\Domain\User;

interface UserRepositoryInterface
{
    /**
     * @param  User $user
     * @return User
     */
    public function create(User  $user): User;

    /**
     * @param  User $user
     * @return User
     */
    public function update(User  $user): User;

    /**
     * @param  string $user
     * @return User|null
     */
    public function findById(string $user): ?User;

    /**
     * @param  string $email
     * @return User|null
     */
    public function findByEmail(string $email): ?User;

    /**
     * @return User[]
     */
    public function findByIds(array $ids): array;

    /**
     * @param  PersonalData $personalData
     * @return PersonalData
     */
    public function updatePersonalInformation(
        PersonalData $personalData
    ): PersonalData;
}
