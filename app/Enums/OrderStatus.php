<?php

namespace App\Enums;

use Illuminate\Validation\Rules\Enum;
use function Laravel\Prompts\select;

class OrderStatus extends Enum
{
    const COMPLETE = 'complete';
    const FULFILLED = 'fulfilled';
    const CANCELLED = 'cancelled';
    const PENDING = 'pending';

    public static function getValues(): array
    {
        return [
            self::COMPLETE,
            self::FULFILLED,
            self::CANCELLED,
            self::PENDING
        ];
    }
}
