<?php

namespace App\Enums;

enum TaskStatus: string
{
    case CREATED = 'created';
    case IN_PROGRESS = 'in progress';
    case COMPLETED = 'completed';

    public static function values(): array
    {
        return array_column(self::cases(), 'value');
    }

    public static function valuesAsString($separator = ', '): string
    {
        return implode($separator, self::values());
    }
}
