<?php

declare(strict_types=1);

namespace MyCare\Shared\Infrastructure\User\Eloquent;

// use Illuminate\Contracts\Auth\MustVerifyEmail;
use Database\Factories\UserFactory;
use Exception;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Notifications\Notifiable;
use Laravel\Sanctum\HasApiTokens;
use MyCare\Shared\Domain\User\PersonalData;
use MyCare\Shared\Domain\User\User as UserDomain;
use MyCare\Shared\Domain\ValueObj\Identifier;
use Spatie\Permission\Traits\HasRoles;

class User extends Authenticatable
{
    public $incrementing = false;

    use HasApiTokens, HasFactory, Notifiable, HasRoles;

    /**
     * The attributes that are mass assignable.
     *
     * @var array<int, string>
     */
    protected $fillable = [
        'id',
        'name',
        'email',
        'type_id',
        'email_verified_at',
        'password',
        'remember_token',
        'created_at',
        'updated_at',
    ];

    /**
     * The attributes that should be hidden for serialization.
     *
     * @var array<int, string>
     */
    protected $hidden = [
        'password',
        'remember_token',
    ];

    /**
     * The attributes that should be cast.
     *
     * @var array<string, string>
     */
    protected $casts = [
        'email_verified_at' => 'datetime',
    ];

    public function userType(): BelongsTo
    {
        return $this->belongsTo(EUserType::class, 'type_id', 'id');
    }

    public static function newFactory(): UserFactory
    {
        return UserFactory::new();
    }

    public static function scopeCreateByDomain($query, UserDomain $user): User
    {
        return $query->create(
            [
                'id' => $user->getId(),
                'name' => $user->getName(),
                'email' => $user->getEmail(),
                'type_id' => $user->getTypeId(),
                'email_verified_at' => $user->getEmailVerifiedAt(),
                'password' => $user->getPassword(),
                'created_at' => $user->getCreatedAt()->format('Y-m-d H:i:s'),
                'updated_at' => $user->getUpdatedAt()->format('Y-m-d H:i:s'),
            ]
        );
    }

    public function scopeUpdateUsingDomain($query, UserDomain $user)
    {
        return $query->update(
            [
                'id' => $user->getId(),
                'name' => $user->getName(),
                'email' => $user->getEmail(),
                'type_id' => $user->getTypeId(),
                'email_verified_at' => $user->getEmailVerifiedAt(),
                'password' => $user->getPassword(),
                'created_at' => $user->getCreatedAt()->format('Y-m-d H:i:s'),
                'updated_at' => $user->getUpdatedAt()->format('Y-m-d H:i:s'),
            ]
        );
    }

    public function personalData()
    {
        return $this->hasOne(EPersonalData::class, 'id', 'id');
    }

    /**
     * @throws Exception
     */
    public function getDomain(): UserDomain
    {
        $id = new Identifier($this->id);
        return new UserDomain(
            id: $id,
            name: $this->name,
            email: $this->email,
            type_id: $this->type_id,
            password: $this->password,
            personal_data: $this->personalData()->get()->first()?->getDomain() ??
            new PersonalData(
                id: $id,
            ),
            email_verified_at: $this->email_verified_at,
            created_at: $this->created_at,
            updated_at: $this->updated_at,
            deleted_at: $this->deleted_at,
        );
    }

}
