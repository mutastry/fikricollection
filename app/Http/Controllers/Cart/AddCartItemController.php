<?php

namespace App\Http\Controllers\Cart;

use App\Http\Controllers\Controller;
use App\Models\Songket;
use App\Rules\SufficientStock;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;

class AddCartItemController extends Controller
{
    /**
     * Handle the incoming request.
     */
    public function __invoke(Request $request)
    {
        try {
            DB::beginTransaction();

            $request->validate([
                'songket_id'        => ['required', 'exists:songkets,id'],
                'quantity'          => ['required', 'integer', 'min:1', 'max:10',  new SufficientStock(
                    $request->songket_id,
                    $request->selected_color,
                )],
                'selected_color'    => ['nullable', 'string'],
                'price'             => ['required', 'numeric', 'min:0'],
            ]);

            $songket = Songket::findOrFail($request->songket_id);

            // Check if item already exists in cart with same options
            $existingItem = Auth::user()->cartItems()
                ->where('songket_id', $request->songket_id)
                ->where('selected_color', $request->selected_color)
                ->first();

            if ($existingItem) {
                $existingItem->update([
                    'quantity' => $existingItem->quantity + $request->quantity,
                ]);
            } else {
                Auth::user()->cartItems()->create([
                    'songket_id'        => $request->songket_id,
                    'quantity'          => $request->quantity,
                    'selected_color'    => $request->selected_color,
                    'price'             => $request->price,
                ]);
            }

            DB::commit();

            if ($request->expectsJson()) {
                return response()->json([
                    'success' => true
                ]);
            }

            return redirect()
                ->back()
                ->with('success', 'Product added to cart successfully!');
        } catch (\Exception $e) {
            DB::rollBack();

            if ($request->expectsJson()) {
                return response()->json([
                    'success' => false,
                    'message' => $e->getMessage(),
                    'error' => $e->getMessage(),
                ], 500);
            }

            return redirect()
                ->back()
                ->with('error', 'Failed to add product to cart.');
        }
    }
}
