<?php

namespace App\Enums;

use Illuminate\Validation\Rules\Enum;

class OrderStatus extends Enum
{
    const COMPLETE = 'complete';
    const FULFILLED = 'fulfilled';
    const CANCELLED = 'cancelled';

    public static function getValues(): array
    {
        return [
            self::COMPLETE,
            self::FULFILLED,
            self::CANCELLED
        ];
    }
}
