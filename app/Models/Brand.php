<?php

namespace App\Models;

use Illuminate\Database\Eloquent\{Builder, Model};
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class Brand extends Model
{
    /** @use HasFactory<\Database\Factories\BrandFactory> */
    use HasFactory;

    protected $guarded = [];

    public function admin(): BelongsTo
    {
        return $this->belongsTo(Admin::class);
    }

    public function scopeSelection(Builder $query): Builder
    {
        return $query->select('name', 'trans_lang', 'id', 'created_at', 'admin_id');
    }
}
