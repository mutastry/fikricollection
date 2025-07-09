<?php

namespace App\Models;

use App\Policies\CartItemPolicy;
use Illuminate\Database\Eloquent\Attributes\UsePolicy;
use Illuminate\Database\Eloquent\Casts\Attribute;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

#[UsePolicy(CartItemPolicy::class)]
class CartItem extends Model
{
    use HasFactory;

    protected $fillable = [
        'user_id',
        'songket_id',
        'quantity',
        'selected_color',
        'price',
    ];

    protected $casts = [
        'quantity' => 'integer',
        'price' => 'decimal:2',
    ];

    public function user(): BelongsTo
    {
        return $this->belongsTo(User::class);
    }

    public function songket(): BelongsTo
    {
        return $this->belongsTo(Songket::class);
    }

    public function totalPrice(): Attribute
    {
        return Attribute::make(
            get: fn() => $this->quantity * $this->price,
        );
    }

    public function formattedTotalPrice(): Attribute
    {
        return Attribute::make(
            get: fn() => 'Rp ' . number_format($this->totalPrice, 0, ',', '.'),
        );
    }
}
