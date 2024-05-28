<?php

namespace App\Enums;

use Illuminate\Validation\Rules\Enum;

class OrderStatus extends Enum
{
    const PENDING = 'pending';
    const FULFILLED = 'fulfilled';
    const CANCELLED = 'cancelled';

    public static function getValues(): array
    {
        return [
            self::PENDING,
            self::FULFILLED,
            self::CANCELLED
        ];
    }
}
