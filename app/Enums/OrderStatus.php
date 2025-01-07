<?php

namespace App\Enums;

use Illuminate\Validation\Rules\Enum;
use function Laravel\Prompts\select;

class OrderStatus extends Enum
{
    const PENDING = 'pending';
    const COMPLETE = 'complete';
    const FULFILLED = 'fulfilled';
    const CANCELLED = 'cancelled';
    const PENDING = 'pending';


    public static function getValues(): array
    {
        return [
            self::PENDING,
            self::COMPLETE,
            self::FULFILLED,
            self::CANCELLED,
            self::PENDING
        ];
    }
}
