<?php

namespace App\Models;

use Illuminate\Database\Eloquent\{Builder, Model};
use Illuminate\Database\Eloquent\Factories\HasFactory;

class Category extends Model
{
    /** @use HasFactory<\Database\Factories\CategoryFactory> */
    use HasFactory;

    public function admin()
    {
        return $this->belongsTo(Admin::class);
    }

    public function scopeSelection(Builder $query): Builder
    {
        return $query->select('name', 'image', 'id', 'created_at', 'admin_id', 'trans_lang');
    }
}
