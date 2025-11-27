<?php

namespace App\Enums;

enum OrderState: int
{
    case Pending         = 1;
    case Processing      = 2;
    case Shipped         = 3;
    case Delivered       = 4;
    case Cancelled       = 5;

    public function label(): string
    {
        return match ($this) {
            self::Pending          => 'pending' ,
            self::Processing       => 'processing',
            self::Shipped          => 'shipped',
            self::Delivered        => 'delivered',
            self::Cancelled        => 'cancelled',
        };
    }
}
