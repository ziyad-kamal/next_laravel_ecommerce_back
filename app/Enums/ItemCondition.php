<?php

namespace App\Enums;

enum ItemCondition: int
{
    case New  = 1;
    case Used = 2;

    public function label(): string
    {
        return match ($this) {
            self::New   => 'new' ,
            self::Used  => 'used'
        };
    }
}
