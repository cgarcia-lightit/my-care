<?php

declare(strict_types=1);

namespace MyCare\Submissions\Domain;

use DateTime;
use Exception;
use MyCare\Shared\Domain\Domain;
use MyCare\Shared\Domain\Traits\UseDate;
use MyCare\Shared\Domain\User\User;
use MyCare\Shared\Domain\ValueObj\Identifier;
use MyCare\Submissions\Domain\Events\PrescriptionSubmitted;
use MyCare\Submissions\Domain\ValueObj\SubmissionStatus;


final class Submission extends Domain
{
    /**
     * @return string|null
     */
    public function getPrescriptions(): ?string
    {
        return $this->prescriptions;
    }

    /**
     * @param  string|null $prescriptions
     * @return void
     */
    public function setPrescriptions(?string $prescriptions): void
    {
        $this->prescriptions = $prescriptions;
    }

    use UseDate;

    /**
     * @throws Exception
     */
    public function __construct(
        private Identifier|string    $id,
        private string               $title,
        private string               $symptoms,
        private SubmissionStatus     $status,
        private readonly User        $patient,
        private User|null            $doctor = null,
        private ?string              $prescriptions = null,
        private DateTime|string      $created_at = new DateTime('now'),
        private DateTime|string      $updated_at = new DateTime('now'),
        private DateTime|string|null $deleted_at = null,
    ) {
        if (!($id instanceof Identifier)) {
            $this->id = new Identifier($id);
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

    /**
     * @return string
     */
    public function getId(): string
    {
        return $this->id->get();
    }

    /**
     * @return DateTime
     */
    public function getCreatedAt(): DateTime
    {
        return $this->created_at;
    }

    /**
     * @throws Exception
     */
    public function setCreatedAt(DateTime|string $created_at): void
    {
        $this->created_at = $created_at instanceof DateTime ?
            $created_at :
            $this->getDateByString($created_at);
    }

    /**
     * @return DateTime
     */
    public function getUpdatedAt(): DateTime
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
            $this->getDateByString($updated_at);
    }

    /**
     * @return DateTime|null
     */
    public function getDeletedAt(): ?DateTime
    {
        return $this->deleted_at;
    }

    /**
     * @throws Exception
     */
    public function setDeletedAt(DateTime|string $deleted_at): void
    {
        $this->deleted_at = $deleted_at instanceof DateTime ?
            $deleted_at :
            $this->getDateByString($deleted_at);
    }

    /**
     * @return string
     */
    public function getTitle(): string
    {
        return $this->title;
    }

    /**
     * @param  string $title
     * @return void
     */
    public function setTitle(string $title): void
    {
        $this->title = $title;
    }

    /**
     * @return User|null
     */
    public function getDoctor(): ?User
    {
        return $this->doctor;
    }

    /**
     * @param  User $user
     * @return void
     */
    public function setDoctor(User $user): void
    {
        if ($user->isDoctor()) {
            $this->doctor = $user;
        }
    }

    /**
     * @return string
     */
    public function getSymptoms(): string
    {
        return $this->symptoms;
    }

    /**
     * @param  string $symptoms
     * @return void
     */
    public function setSymptoms(string $symptoms): void
    {
        $this->symptoms = $symptoms;
    }

    /**
     * @return SubmissionStatus
     */
    public function getStatus(): SubmissionStatus
    {
        return $this->status;
    }

    /**
     * @throws Exception
     */
    public function updateStatus(SubmissionStatus $nextStatus): void
    {
        if ($this->status->canProceedTo($nextStatus)) {
            $this->status = $nextStatus;
        } else {
            throw new Exception("Invalid transition from {$this->status->name} to {$nextStatus->name}.");
        }
    }

    /**
     * @return array
     */
    function toArray(): array
    {
        return [
            'id' => $this->id->get(),
            'title' => $this->title,
            'symptoms' => $this->symptoms,
            'status' => $this->status->value,
            'patient' => $this->patient->toArray(),
            'doctor' => $this->doctor?->toArray(),
            'prescriptions' => $this->prescriptions,
            'created_at' => $this->created_at->format($this->DATE_FORMAT_OUTPUT),
            'updated_at' => $this->updated_at->format($this->DATE_FORMAT_OUTPUT),
            'deleted_at' => $this->deleted_at?->format($this->DATE_FORMAT_OUTPUT),
        ];
    }

    /**
     * @return User
     */
    public function getPatient(): User
    {
        return $this->patient;
    }

    /**
     * @return bool
     */
    public function canAttachPrescription(): bool
    {
        return $this->status === SubmissionStatus::IN_PROGRESS;
    }

    /**
     * @param $prescriptions
     */
    public function attachPrescription($prescriptions): void
    {
        $fileName = uniqid('prescription-');
        $path = "/MyCare/Submissions/$this->id/$fileName." . $prescriptions->clientExtension();
        $this->prescriptions = $path;
        $this->pushEvent(new PrescriptionSubmitted($this, $prescriptions));
    }

    /**
     * @return array
     */
    public function getUsers(): array
    {
        return array_filter(
            [
                'patient' => $this->patient->get(),
                'doctor' => $this->doctor?->get(),
            ], fn($value) => !is_null($value)
        );
    }
}
