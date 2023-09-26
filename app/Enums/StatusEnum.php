<?php

namespace App\Enums;


use BenSampo\Enum\Enum;

final class StatusEnum extends Enum
{
    const PENDING = 'pending';
    const ACTIVE = 'active';
    const CANCELED = 'canceled';
}
