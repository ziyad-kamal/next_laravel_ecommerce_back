<?php

namespace App\Models;

use App\Enums\{OrderMethod, OrderState};
use Illuminate\Database\Eloquent\{Builder, Model};
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class Order extends Model
{
    /** @use HasFactory<\Database\Factories\OrderFactory> */
    use HasFactory;

    protected $guarded = [];

    protected function casts(): array
    {
        return [
            'state'            => OrderState::class,
            'method'           => OrderMethod::class,
        ];
    }

    public function user(): BelongsTo
    {
        return $this->belongsTo(User::class);
    }

    public function items()
    {
        return $this->belongsToMany(Item::class, 'order_item');
    }

    public function transaction()
    {
        return $this->hasOne(Transaction::class);
    }

    public function scopeSelection(Builder $query): Builder
    {
        return $query->select('total_amount', 'state', 'date_of_delivery', 'method', 'id');
    }
}
