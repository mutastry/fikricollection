<?php

namespace App\Http\Controllers\Cart;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class ClearCartController extends Controller
{
    /**
     * Handle the incoming request.
     */
    public function __invoke(Request $request)
    {
        try {
            Auth::user()
                ->cartItems()
                ->delete();

            return response()->json([
                'success'   => true,
                'message'   => 'Cart cleared successfully!',
            ]);
        } catch (\Exception $e) {
            return response()->json([
                'success'   => false,
                'message'   => 'Failed to clear cart.',
                'error'     => $e->getMessage(),
            ], 500);
        }
    }
}
