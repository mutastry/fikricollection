<?php

namespace App\Http\Controllers\Order;

use App\Http\Controllers\Controller;
use App\Models\Order;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Gate;

class ConfirmationController extends Controller
{
    /**
     * Handle the incoming request.
     */
    public function __invoke(Order $order)
    {
        // $this->authorize('view', $order);
        Gate::authorize('view', $order);

        $order->load(['payment', 'orderItems.songket']);

        return view('checkout.confirmation', compact('order'));
    }
}
