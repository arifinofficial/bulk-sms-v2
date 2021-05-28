<?php

namespace App\Enum;

final class BroadcastStatus extends \Konekt\Enum\Enum
{
    const PENDING = 'PENDING';
    const FAILED = 'FAILED';
    const PROCESSING = 'PROCESSING';
    const COMPLETED = 'COMPLETED';
}
