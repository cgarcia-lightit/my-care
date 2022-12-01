<?php

declare(strict_types=1);

namespace MyCare\Shared\Domain\User;

use DateTime;
use Exception;
use Illuminate\Notifications\Notifiable;
use MyCare\Shared\Domain\Domain;
use MyCare\Shared\Domain\Traits\UseDate;
use MyCare\Shared\Domain\User\Events\CreatedUserEvent;
use MyCare\Shared\Domain\ValueObj\Identifier;
use MyCare\Shared\Domain\ValueObj\UserTypeEnum;

final class User extends Domain
{
    use UseDate;
    use Notifiable;

    protected array $hidden = [
      'password'
    ];

    /**
     * @throws Exception
     */
    public function __construct(
        private readonly Identifier  $id,
        private string               $name,
        private string               $email,
        private string               $type_id,
        private string               $password,
        private PersonalData         $personal_data,
        private DateTime|string|null $email_verified_at = null,
        private DateTime|string      $created_at = new DateTime('now'),
        private DateTime|string      $updated_at = new DateTime('now'),
        private DateTime|string|null $deleted_at = null
    ) {
        if (!$email_verified_at instanceof DateTime && !is_null($email_verified_at)) {
            $this->email_verified_at = $this->getDateByString($email_verified_at);
        }
        if (!$created_at instanceof DateTime) {
            $this->created_at = $this->getDateByString($created_at);
        }
        if (!$updated_at instanceof DateTime) {
            $this->updated_at = $this->getDateByString($updated_at);
        }
        if (!$deleted_at instanceof DateTime && !is_null($this->deleted_at)) {
            $this->deleted_at = $this->getDateByString($deleted_at);
        }
    }

    public function toArray(): array
    {
        return [
            'id' => $this->id->get(),
            'name' => $this->name,
            'email' => $this->email,
            'email_verified_at' => $this->email_verified_at,
            'type_id' => $this->type_id,
            'password' => $this->password,
            'personal_data' => $this->personal_data->toArray(),
            'created_at' => $this->created_at->format($this->DATE_FORMAT_OUTPUT),
            'updated_at' => $this->updated_at->format($this->DATE_FORMAT_OUTPUT),
            'deleted_at' => $this->deleted_at?->format($this->DATE_FORMAT_OUTPUT),
        ];
    }

    public function getName(): string
    {
        return $this->name;
    }

    public function setName(string $name): void
    {
        $this->name = $name;
    }

    public function getEmail(): string
    {
        return $this->email;
    }

    public function setEmail(string $email): void
    {
        $this->email = $email;
    }

    public function getTypeId(): string
    {
        return $this->type_id;
    }

    public function setTypeId(string $type_id): void
    {
        $this->type_id = $type_id;
    }

    public function getPassword(): string
    {
        return $this->password;
    }

    public function setPassword(string $password): void
    {
        $this->password = $password;
    }

    public function getEmailVerifiedAt(): DateTime|string|null
    {
        return $this->email_verified_at;
    }

    public function setEmailVerifiedAt(DateTime|string|null $email_verified_at): void
    {
        $this->email_verified_at = $email_verified_at;
    }

    public function getCreatedAt(): DateTime|string
    {
        return $this->created_at;
    }

    public function setCreatedAt(DateTime|string $created_at): void
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
        $this->updated_at = $updated_at instanceof DateTime ?
                            $updated_at :
                            new DateTime($updated_at);
    }

    public function getDeletedAt(): DateTime|string|null
    {
        return $this->deleted_at;
    }

    /**
     * @throws Exception
     * @throws Exception
     */
    public function setDeletedAt(DateTime|string|null $deleted_at): void
    {
        $this->deleted_at = $deleted_at instanceof DateTime ?
                            $deleted_at :
            new DateTime($deleted_at);
    }

    public function getId(): string
    {
        return $this->id->get();
    }

    public function isVerified(): bool
    {
        return $this->email_verified_at instanceof DateTime;
    }

    /**
     * @throws Exception
     */
    public static function create(
        string $name,
        string $email,
        UserTypeEnum $type_id,
        string $password
    ): self {
        $id = new Identifier();
        $user = new User(
            id: $id,
            name: $name,
            email: $email,
            type_id: $type_id->value,
            password: bcrypt($password),
            personal_data: new PersonalData(
                id: $id,
            )
        );
        $user->pushEvent(new CreatedUserEvent($user));
        return $user;
    }

    /**
     * @throws Exception
     */
    public function verifyEmail()
    {
        if ($this->email_verified_at === null ) {
            $this->email_verified_at = new DateTime('now');
        } else {
            throw new Exception('Email was verified previously. you can not verify the email again.', 422);
        }
    }

    public function isDoctor(): bool
    {
        return $this->type_id === UserTypeEnum::DOCTOR->value;
    }

    public function getPersonalData(): PersonalData
    {
        return $this->personal_data;
    }

    public function setPersonalData(PersonalData $personal_data): void
    {
        $this->personal_data = $personal_data;
    }


}
