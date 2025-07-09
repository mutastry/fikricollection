<?php

namespace App\Rules;

use App\Models\Songket;
use Closure;
use Illuminate\Contracts\Validation\ValidationRule;
use Illuminate\Support\Facades\Auth;

class SufficientStock implements ValidationRule
{
    protected $songketId;
    protected $selectedColor;

    public function __construct($songketId, $selectedColor = null)
    {
        $this->songketId = $songketId;
        $this->selectedColor = $selectedColor;
    }

    /**
     * Run the validation rule.
     *
     * @param  \Closure(string, ?string=): \Illuminate\Translation\PotentiallyTranslatedString  $fail
     */
    public function validate(string $attribute, mixed $value, Closure $fail): void
    {
        $songket = Songket::find($this->songketId);

        if (!$songket) {
            $fail('Product not found.');
            return;
        }

        if (!$songket->is_active) {
            $fail('This product is currently unavailable.');
            return;
        }

        // Check if requested quantity exceeds available stock
        if ($value > $songket->stock_quantity) {
            $fail("Only {$songket->stock_quantity} items available in stock.");
            return;
        }

        // Check existing cart items for the same product with same options
        $existingCartQuantity = 0;
        if (Auth::check()) {
            $existingItem = Auth::user()->cartItems()
                ->where('songket_id', $this->songketId)
                ->where('selected_color', $this->selectedColor)
                ->first();

            if ($existingItem) {
                $existingCartQuantity = $existingItem->quantity;
            }
        }

        $totalRequestedQuantity = $existingCartQuantity + $value;

        if ($totalRequestedQuantity > $songket->stock_quantity) {
            $availableQuantity = $songket->stock_quantity - $existingCartQuantity;

            if ($availableQuantity <= 0) {
                $fail('This item is already at maximum quantity in your cart.');
                return;
            }

            $fail("You can only add {$availableQuantity} more of this item to your cart.");
            return;
        }
    }
}
