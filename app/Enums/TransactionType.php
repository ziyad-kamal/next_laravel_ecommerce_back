<?php

namespace App\Enums;

enum TransactionType: int
{
    case Buy         = 1;
    case Refund      = 2;

    public function label(): string
    {
        return match ($this) {
            self::Buy          => 'buy' ,
            self::Refund       => 'refund',
        };
    }
}
