<?php

namespace App\Enums;

enum IsActiveEnum: string
{
    case ACTIVE = 'active';
    case INACTIVE = 'inactive';

    public static function typeGenerate(bool $type) {
        return $type ? self::ACTIVE->value : self::INACTIVE->value;
    }
}
