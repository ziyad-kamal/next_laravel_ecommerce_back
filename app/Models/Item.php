<?php

namespace App\Models;

use Illuminate\Database\Eloquent\{Builder, Model};
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Relations\{BelongsTo, HasMany, HasOne};

class Item extends Model
{
    /** @use HasFactory<\Database\Factories\ItemFactory> */
    use HasFactory;

    protected $guarded = [];

    public function admin(): BelongsTo
    {
        return $this->belongsTo(Admin::class);
    }

    public function vendor(): BelongsTo
    {
        return $this->belongsTo(Vendor::class);
    }

    public function category(): BelongsTo
    {
        return $this->belongsTo(Category::class);
    }

    public function brand(): BelongsTo
    {
        return $this->belongsTo(Brand::class);
    }

    public function item_info(): HasOne
    {
        return $this->hasOne(Item_info::class);
    }

    public function item_files(): HasMany
    {
        return $this->hasMany(Item_files::class, 'item_id');
    }

    public function scopeSelection(Builder $query): Builder
    {
        return $query->select('name', 'id', 'created_at', 'admin_id', 'trans_lang', 'approve', 'brand_id', 'category_id');
    }
}
