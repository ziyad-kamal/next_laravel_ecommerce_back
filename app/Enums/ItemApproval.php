<?php

namespace App\Enums;

enum ItemApproval: int
{
    case Approved  = 2;
    case Refused   = 3;
    case Pending   = 1;

    public function label(): string
    {
        return match ($this) {
            self::Approved   => 'approved' ,
            self::Pending    => 'pending',
            self::Refused    => 'refused',
        };
    }
}
