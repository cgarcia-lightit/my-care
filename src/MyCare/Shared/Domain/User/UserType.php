<?php

declare(strict_types=1);

namespace MyCare\Shared\Domain\User;

use DateTime;
use Exception;
use MyCare\Shared\Domain\Domain;
use MyCare\Shared\Domain\Traits\UseDate;
use MyCare\Shared\Domain\ValueObj\UserTypeEnum;

final class UserType extends Domain
{
    use UseDate;

    /**
     * @throws Exception
     */
    public function __construct(
        private readonly UserTypeEnum $id,
        private DateTime|string $created_at = new DateTime('now'),
        private DateTime|string $updated_at = new DateTime('now'),
        private readonly ?DateTime $deleted_at = null
    ) {
        if (!($created_at instanceof DateTime)) {
            $this->created_at = $this->getDateByString($created_at);
        }
        if (!($updated_at instanceof DateTime)) {
            $this->updated_at = $this->getDateByString($updated_at);
        }
    }

    public function getId(): string
    {
        return $this->id->value;
    }

    public function getCreatedAt(): DateTime|string
    {
        return $this->created_at;
    }

    public function getUpdatedAt(): DateTime|string
    {
        return $this->updated_at;
    }

    public function getDeletedAt(): ?DateTime
    {
        return $this->deleted_at;
    }

    function toArray(): array
    {
        return [
            'id' => $this->id,
            'created_at' => $this->created_at,
            'updated_at' => $this->updated_at,
            'deleted_at' => $this->deleted_at,
        ];
    }
}
