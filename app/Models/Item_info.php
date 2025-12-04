<?php

namespace App\Models;

use App\Enums\ItemCondition;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Item_info extends Model
{
    /** @use HasFactory<\Database\Factories\ItemInfoFactory> */
    use HasFactory;

    protected $guarded = [];

    protected function casts(): array
    {
        return [
            'condition'           => ItemCondition::class,
        ];
    }
}
