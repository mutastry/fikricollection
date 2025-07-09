<?php

namespace App\Http\Controllers\Order;

use App\Enums\OrderStatus;
use App\Enums\PaymentMethod;
use App\Enums\PaymentStatus;
use App\Http\Controllers\Controller;
use App\Http\Requests\Order\CheckoutRequest;
use App\Models\Order;
use App\Models\Payment;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;
use Illuminate\Validation\Rule;

class CheckoutController extends Controller
{
    public function index()
    {
        $cartItems = Auth::user()->cartItems()->with('songket.category')->get();

        if ($cartItems->isEmpty()) {
            return redirect()->route('cart.index')->with('error', 'Your cart is empty. Please add items before checkout.');
        }

        foreach ($cartItems as $cartItem) {
            if ($cartItem->songket->stock_quantity < $cartItem->quantity) {
                return redirect()->route('cart.index')
                    ->with('error', "Insufficient stock for {$cartItem->songket->name}. Only {$cartItem->songket->stock_quantity} items available.");
            }
        }

        $total = $cartItems->sum('total_price');

        return view('checkout.index', compact('cartItems', 'total'));
    }

    public function store(CheckoutRequest $request)
    {
        $cartItems = Auth::user()->cartItems()->with('songket')->get();

        if ($cartItems->isEmpty()) {
            return redirect()->route('cart.index')->with('error', 'Your cart is empty. Please add items before checkout.');
        }

        foreach ($cartItems as $cartItem) {
            if ($cartItem->songket->stock_quantity < $cartItem->quantity) {
                return redirect()->route('cart.index')
                    ->with('error', "Insufficient stock for {$cartItem->songket->name}. Only {$cartItem->songket->stock_quantity} items available.");
            }
        }

        $total = $cartItems->sum('total_price');

        DB::beginTransaction();

        try {
            // Create order
            $order = Order::create([
                'user_id'           => Auth::id(),
                'status'            => OrderStatus::PENDING,
                'total_amount'      => $total,
                'customer_name'     => $request->customer_name,
                'customer_email'    => $request->customer_email,
                'customer_phone'    => $request->customer_phone,
                'customer_address'  => $request->customer_address,
                'notes'             => $request->notes,
            ]);

            // Create order items
            foreach ($cartItems as $cartItem) {
                $order->orderItems()->create([
                    'songket_id'        => $cartItem->songket_id,
                    'quantity'          => $cartItem->quantity,
                    'selected_color'    => $cartItem->selected_color,
                    'price'             => $cartItem->price,
                    'total_price'       => $cartItem->total_price,
                ]);
            }

            // Clear cart
            Auth::user()->cartItems()->delete();

            DB::commit();

            return redirect()->route('checkout.payment', $order)->with('success', 'Order created successfully! Please complete your payment.');
        } catch (\Exception $e) {
            DB::rollback();
            return back()->withInput()->with('error', 'Something went wrong while processing your order. Please try again.');
        }
    }
}
