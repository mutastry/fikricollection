<?php

namespace App\Http\Controllers\Cart;

use App\Http\Controllers\Controller;
use App\Models\CartItem;
// use App\Models\Songket;
// use Illuminate\Auth\Access\Gate;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Gate;

// use Illuminate\Support\Facades\Gate as FacadesGate;

class CartController extends Controller
{
    public function index()
    {
        $cartItems = Auth::user()->cartItems()->with('songket.category')->get();
        $total = $cartItems->sum('total_price');

        return view('cart.index', compact('cartItems', 'total'));
    }

    public function update(Request $request, CartItem $cartItem)
    {
        // $this->authorize('update', $cartItem);
        Gate::authorize('update', $cartItem);

        $request->validate([
            'quantity' => ['required', 'integer', 'min:1', 'max:10'],
        ]);

        try {
            DB::beginTransaction();

            $cartItem->update([
                'quantity' => $request->quantity,
            ]);

            DB::commit();

            if ($request->expectsJson()) {
                return response()->json([
                    'success'       => true,
                    'total_price'   => $cartItem->formatted_total_price,
                    'cart_total'    => Auth::user()->cartItems()->sum('price'),
                ]);
            }

            return redirect()->back()->with('success', 'Cart updated successfully!');
        } catch (\Exception $e) {
            DB::rollBack();

            if ($request->expectsJson()) {
                return response()->json([
                    'success' => false,
                    'message' => $e->getMessage(),
                ], 500);
            }

            return redirect()->back()->with('error', 'Failed to update cart item.');
        }
    }

    public function destroy(CartItem $cartItem)
    {
        // $this->authorize('delete', $cartItem);
        Gate::authorize('delete', $cartItem);

        $cartItem->delete();

        // return redirect()->back()->with('success', 'Item removed from cart!');
        return response()->json([
            'success' => true,
            'message' => 'Item removed from cart!',
        ]);
    }
}
