<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Casts\Attribute;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class OrderItem extends Model
{
    use HasFactory;

    protected $fillable = [
        'order_id',
        'songket_id',
        'quantity',
        'selected_color',
        'price',
        'total_price',
    ];

    protected $casts = [
        'quantity' => 'integer',
        'price' => 'decimal:2',
        'total_price' => 'decimal:2',
    ];

    public function order(): BelongsTo
    {
        return $this->belongsTo(Order::class);
    }

    public function songket(): BelongsTo
    {
        return $this->belongsTo(Songket::class);
    }

    public function formattedTotalPrice(): Attribute
    {
        return Attribute::make(
            get: fn() => 'Rp ' . number_format($this->total_price, 0, ',', '.'),
        );
    }
}
