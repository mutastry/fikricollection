<?php

namespace App\Http\Controllers\Order;

use App\Models\Order;
use App\Rules\StatusCanBeChanged;
use App\Enums\OrderStatus;
use App\Enums\PaymentStatus;
use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Gate;

class CancelOrderController extends Controller
{
    /**
     * Handle the incoming request.
     */
    public function __invoke(Request $request, Order $order)
    {
        // Check if user can view this order (owns it)
        Gate::authorize('view', $order);

        // Validate that the order can be cancelled
        $request->validate([
            'status' => [
                'required',
                'in:canceled',
                new StatusCanBeChanged($order->status, 'order')
            ]
        ], [
            'status.in' => 'Invalid status value.',
        ]);

        // Check if the order status allows cancellation
        $allowedTransitions = StatusCanBeChanged::getAllowedTransitions($order->status, 'order');

        if (!in_array(OrderStatus::CANCELLED->value, $allowedTransitions)) {
            return back()->with('error', 'This order cannot be cancelled at this time.');
        }

        // Update order status to cancelled
        $order->update([
            'status' => OrderStatus::CANCELLED
        ]);

        // If the order has a payment, update its status to failed
        if ($order->payment) {
            $order->payment->update([
                'payment_status' => PaymentStatus::FAILED,
            ]);
        }

        return back()->with('success', 'Order has been cancelled successfully.');
    }
}
