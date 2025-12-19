<?php

namespace App\Models;

use Illuminate\Database\Eloquent\{Builder, Model};
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class Category extends Model
{
    /** @use HasFactory<\Database\Factories\CategoryFactory> */
    use HasFactory;

    protected $guarded = [];

    public function admin(): BelongsTo
    {
        return $this->belongsTo(Admin::class);
    }

    public function items()
    {
        return $this->hasMany(Item::class);
    }

    public function scopeSelection(Builder $query): Builder
    {
        return $query->select('name', 'image', 'id', 'created_at', 'admin_id', 'trans_lang');
    }
}
