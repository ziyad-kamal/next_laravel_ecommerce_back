<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class User_info extends Model
{
    /** @use HasFactory<\Database\Factories\UserInfoFactory> */
    use HasFactory;

    protected function casts(): array
    {
        return [
            'card_num'  => 'encrypted',
        ];
    }
}
