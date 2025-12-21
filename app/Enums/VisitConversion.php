<?php

namespace App\Enums;

enum VisitConversion: int
{
    case SignedUp               = 1;
    case NotSignedUp            = 0;

    public function label(): string
    {
        return match ($this) {
            self::SignedUp                => 'signedUp' ,
            self::NotSignedUp             => 'not singedUp',
        };
    }
}
