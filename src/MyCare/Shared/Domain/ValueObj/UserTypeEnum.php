<?php

declare(strict_types=1);

namespace MyCare\Shared\Domain\ValueObj;

enum UserTypeEnum : string
{
    case DOCTOR = 'DOCTOR';
    case PATIENT = 'PATIENT';
    case ADMIN = 'ADMIN';
}
