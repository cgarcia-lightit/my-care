<?php

declare(strict_types=1);

namespace MyCare\Shared\Infrastructure\User\Eloquent;

use Database\Factories\EPersonalDataFactory;
use Exception;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;
use MyCare\Shared\Domain\User\PersonalData;
use MyCare\Shared\Domain\ValueObj\Identifier;

final class EPersonalData extends Model
{
    use HasFactory;
    use SoftDeletes;

    public $incrementing = false;

    protected $table = 'patient_information';

    protected $fillable = [
        'id',
        'contact_phone',
        'weight',
        'height',
        'other_info',
        'created_at',
        'updated_at',
        'deleted_at',
    ];

    public function user()
    {
        return $this->belongsTo(User::class, 'id', 'id');
    }

    /**
     * @throws Exception
     */
    public function getDomain()
    {
        return new PersonalData(
            id: new Identifier($this->id),
            contact_phone: $this->contact_phone,
            weight: $this->weight,
            height: $this->height,
            other_info: $this->other_info,
            created_at: $this->created_at,
            updated_at: $this->updated_at,
            deleted_at: $this->deleted_at
        );
    }

    /**
     * @return EPersonalData
     */
    public static function fromDomain(PersonalData $data)
    {
        return new self(
            [
                'id' => $data->getId(),
                'contact_phone' => $data->getContactPhone(),
                'weight' => $data->getWeight(),
                'height' => $data->getHeight(),
                'other_info' => $data->getOtherInfo(),
                'created_at' => $data->getCreatedAt(),
                'updated_at' => $data->getUpdatedAt(),
                'deleted_at' => $data->getDeletedAt()
            ]
        );
    }

    public static function newFactory()
    {
        return EPersonalDataFactory::new();
    }

    public function scopeUpdateUsingDomain($query, PersonalData $data)
    {
        return $query->update(
            [
                'id' => $data->getId(),
                'contact_phone' => $data->getContactPhone(),
                'weight' => $data->getWeight(),
                'height' => $data->getHeight(),
                'other_info' => $data->getOtherInfo(),
                'created_at' => $data->getCreatedAt(),
                'updated_at' => $data->getUpdatedAt(),
                'deleted_at' => $data->getDeletedAt()
            ]
        );
    }
}
