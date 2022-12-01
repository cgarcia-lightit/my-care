<?php

declare(strict_types=1);

namespace MyCare\Shared\Domain\User;

use DateTime;
use Exception;
use MyCare\Shared\Domain\Domain;
use MyCare\Shared\Domain\Traits\UseDate;
use MyCare\Shared\Domain\User\Events\PersonalDataUpdatedEvent;
use MyCare\Shared\Domain\ValueObj\Identifier;

final class PersonalData extends Domain
{
    use UseDate;

    /**
     * @throws Exception
     */
    public function __construct(
        private readonly Identifier $id,
        private ?string $contact_phone = null,
        private ?string $weight = null,
        private ?string $height = null,
        private ?string $other_info = null,
        private DateTime $created_at = new DateTime('now'),
        private DateTime|string $updated_at = new DateTime('now'),
        private DateTime|string|null $deleted_at = null
    ) {
        if (!($updated_at instanceof DateTime)) {
            $this->updated_at = $this->getDateByString($updated_at);
        }
        if (!($this->deleted_at instanceof DateTime) && $this->deleted_at !== null) {
            $this->deleted_at = $this->getDateByString($deleted_at);
        }
    }

    public function getId(): string
    {
        return $this->id->get();
    }

    public function getContactPhone(): ?string
    {
        return $this->contact_phone;
    }

    public function setContactPhone(string $contact_phone): void
    {
        $this->contact_phone = $contact_phone;
    }

    public function getWeight(): ?string
    {
        return $this->weight;
    }

    public function setWeight(string $weight): void
    {
        $this->weight = $weight;
    }

    public function getHeight(): ?string
    {
        return $this->height;
    }

    public function setHeight(string $height): void
    {
        $this->height = $height;
    }

    public function getOtherInfo(): ?string
    {
        return $this->other_info;
    }

    public function setOtherInfo(string $other_info): void
    {
        $this->other_info = $other_info;
    }

    public function getCreatedAt(): DateTime
    {
        return $this->created_at;
    }

    public function setCreatedAt(DateTime $created_at): void
    {
        $this->created_at = $created_at;
    }

    public function getUpdatedAt(): DateTime|string
    {
        return $this->updated_at;
    }

    /**
     * @throws Exception
     */
    public function setUpdatedAt(DateTime|string $updated_at): void
    {
        $this->updated_at = $this->getDateByString($updated_at);
    }

    public function getDeletedAt(): ?DateTime
    {
        return $this->deleted_at;
    }

    /**
     * @throws Exception
     */
    public function setDeletedAt(DateTime|string|null $deleted_at): void
    {
        $this->deleted_at = $deleted_at instanceof DateTime ? $deleted_at : $this->getDateByString($deleted_at);
    }

    public function toArray(): array
    {
        return [
            'id' => $this->id->get(),
            'contact_phone' => $this->contact_phone,
            'weight' => $this->weight,
            'height' => $this->height,
            'other_info' => $this->other_info,
            'created_at' => $this->created_at->format($this->DATE_FORMAT_OUTPUT),
            'updated_at' => $this->updated_at->format($this->DATE_FORMAT_OUTPUT),
            'deleted_at' => $this->deleted_at?->format($this->DATE_FORMAT_OUTPUT),
        ];
    }


    /**
     * @throws Exception
     */
    public function update($contact_phone, $weight, $height, $otherInfo)
    {
        $this->setContactPhone($contact_phone);
        $this->setWeight($weight);
        $this->setHeight($height);
        $this->setOtherInfo($otherInfo);
        $this->setUpdatedAt(new DateTime('now'));
        $this->pushEvent(new PersonalDataUpdatedEvent($this));
    }
}
