<?php

declare(strict_types=1);

namespace MyCare\Shared\Infrastructure\User\Eloquent;

use Database\Factories\UserTypeFactory;
use Exception;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;
use MyCare\Shared\Domain\User\UserType;
use MyCare\Shared\Domain\ValueObj\UserTypeEnum;

final class EUserType extends Model
{
    use HasFactory;

    use SoftDeletes;

    protected $table = 'user_types';

    protected $fillable = [
        'id',
        'updated_at',
        'created_at',
        'deleted_at',
    ];

    public $incrementing = false;

    /**
     * @throws Exception
     */
    public static function mapEtypesToDomain($types): array
    {
        $typesToReturn = [];
        foreach ($types as $type) {
            $typesToReturn[] = self::mapEmodelToDomain($type);
        }
        return $typesToReturn;
    }

    /**
     * @throws Exception
     */
    public static function mapEmodelToDomain(EUserType $type): UserType
    {
        return new UserType(
            id: UserTypeEnum::from($type->id),
            created_at: $type->created_at,
            updated_at: $type->updated_at,
            deleted_at: $type->deleted_at,
        );
    }

    /**
     * @throws Exception
     */
    public function getModel(): UserType
    {
        return new UserType(
            id: UserTypeEnum::from($this->id),
            created_at: $this->created_at,
            updated_at: $this->updated_at,
            deleted_at: $this->deleted_at,
        );
    }

    public static function newFactory(): UserTypeFactory
    {
        return UserTypeFactory::new();
    }
}

