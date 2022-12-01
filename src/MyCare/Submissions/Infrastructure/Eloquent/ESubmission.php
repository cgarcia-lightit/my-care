<?php

declare(strict_types=1);

namespace MyCare\Submissions\Infrastructure\Eloquent;

use Exception;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use MyCare\Shared\Infrastructure\User\Eloquent\User;
use MyCare\Submissions\Domain\Submission;
use MyCare\Submissions\Domain\ValueObj\SubmissionStatus;

final class ESubmission extends Model
{
    protected $table = 'submissions';

    public $incrementing = false;

    protected $fillable = [
        'id',
        'title',
        'symptoms',
        'status',
        'patient_id',
        'doctor_id',
        'prescriptions',
        'created_at',
        'updated_at',
        'deleted_at',
    ];

    public static function by(Submission $submission): ESubmission
    {
        return new self(
            [
                'id' => $submission->getId(),
                'title' => $submission->getTitle(),
                'symptoms' => $submission->getSymptoms(),
                'status' => $submission->getStatus()->name,
                'patient_id' => $submission->getPatient()->getId(),
                'doctor_id' => $submission->getDoctor()?->getId(),
                'prescriptions' => $submission->getPrescriptions(),
                'created_at' => $submission->getCreatedAt()->format('Y-m-d H:i:s'),
                'updated_at' => $submission->getUpdatedAt()->format('Y-m-d H:i:s'),
                'deleted_at' => $submission->getDeletedAt()?->format('Y-m-d H:i:s'),
            ]
        );
    }

    public function scopeUpdateUsingDomain($query, Submission $submission)
    {
        return $query->where('id', $submission->getId())
            ->update(
                [
                    'id' => $submission->getId(),
                    'title' => $submission->getTitle(),
                    'symptoms' => $submission->getSymptoms(),
                    'status' => $submission->getStatus()->name,
                    'patient_id' => $submission->getPatient()->getId(),
                    'doctor_id' => $submission->getDoctor()?->getId(),
                    'prescriptions' => $submission->getPrescriptions(),
                    'created_at' => $submission->getCreatedAt()->format('Y-m-d H:i:s'),
                    'updated_at' => $submission->getUpdatedAt()->format('Y-m-d H:i:s'),
                    'deleted_at' => $submission->getDeletedAt()?->format('Y-m-d H:i:s'),
                ]
            );
    }

    public function scopeCreateUsingDomain($query, Submission $submission)
    {
        return $query->create(
            [
                'id' => $submission->getId(),
                'title' => $submission->getTitle(),
                'symptoms' => $submission->getSymptoms(),
                'status' => $submission->getStatus()->name,
                'patient_id' => $submission->getPatient()->getId(),
                'doctor_id' => $submission->getDoctor()?->getId(),
                'prescriptions' => $submission->getPrescriptions(),
                'created_at' => $submission->getCreatedAt()->format('Y-m-d H:i:s'),
                'updated_at' => $submission->getUpdatedAt()->format('Y-m-d H:i:s'),
                'deleted_at' => $submission->getDeletedAt()?->format('Y-m-d H:i:s'),
            ]
        );
    }

    /**
     * @throws Exception
     */
    public function getDomain(): Submission
    {
        return new Submission(
            id: $this->id,
            title: $this->title,
            symptoms: $this->symptoms,
            status: SubmissionStatus::from($this->status),
            patient: $this->patient()->first()->getDomain(),
            doctor: $this->doctor()->first()?->getDomain(),
            prescriptions: $this->prescriptions,
            created_at: $this->created_at,
            updated_at: $this->updated_at,
            deleted_at: $this->deleted_at,
        );
    }

    public function patient(): BelongsTo
    {
        return $this->belongsTo(User::class, 'patient_id', 'id');
    }

    public function doctor(): BelongsTo
    {
        return $this->belongsTo(User::class, 'doctor_id', 'id');
    }
}
