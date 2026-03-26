<?php

namespace App\Enums;

enum AdminRole: int
{
    case admin           = 1;
    case superAdmin      = 2;
    case Owner           = 3;

    public function label(): string
    {
        return match ($this) {
            self::admin            => 'admin' ,
            self::superAdmin       => 'super admin',
            self::Owner            => 'Owner',

        };
    }
}
