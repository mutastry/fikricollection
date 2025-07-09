<?php

namespace App\Http\Controllers\Order;

use App\Enums\PaymentStatus;
use App\Http\Controllers\Controller;
use App\Models\Order;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Gate;

class PaymentController extends Controller
{
    /**
     * Handle the incoming request.
     */
    public function __invoke(Order $order)
    {
        // $this->authorize('view', $order);
        Gate::authorize('view', $order);

        // Check if payment already exists
        if ($order->payment && $order->payment->payment_status !== PaymentStatus::FAILED) {
            return redirect()->route('checkout.confirmation', $order);
        }

        return view('checkout.payment', compact('order'));
    }
}
