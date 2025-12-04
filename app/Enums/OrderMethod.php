<?php

namespace App\Enums;

enum OrderMethod: int
{
    case Cash           = 1;
    case Online         = 2;

    public function label(): string
    {
        return match ($this) {
            self::Cash          => 'cash' ,
            self::Online        => 'online',
        };
    }
}
