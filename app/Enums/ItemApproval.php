<?php

namespace App\Enums;

enum ItemApproval: int
{
    case Approved  = 1;
    case Refused   = 2;
    case Pending   = 3;

    public function label(): string
    {
        return match ($this) {
            self::Approved   => 'approved' ,
            self::Pending    => 'pending',
            self::Refused    => 'refused',
        };
    }
}
