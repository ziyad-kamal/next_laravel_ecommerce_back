<?php

namespace App\Models;

use Illuminate\Database\Eloquent\{Builder, Model};
use Illuminate\Database\Eloquent\Factories\HasFactory;

class Item_files extends Model
{
    /** @use HasFactory<\Database\Factories\ItemFactory> */
    use HasFactory;

    protected $table = 'items_files';

    protected $guarded = [];

    public function scopeSelection(Builder $query): Builder
    {
        return $query->select('path', 'item_id', 'created_at');
    }
}
