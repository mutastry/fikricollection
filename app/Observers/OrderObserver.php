<?php

namespace App\Observers;

use App\Models\Order;
use App\Models\Songket;
use App\Enums\OrderStatus;
use Illuminate\Support\Facades\Log;

class OrderObserver
{
    /**
     * Handle the Order "created" event.
     */
    public function created(Order $order): void
    {
        // When order is created with pending_payment status, decrease stock
        if ($order->status === OrderStatus::PENDING_PAYMENT) {
            $this->decreaseStock($order);
        }
    }

    /**
     * Handle the Order "updated" event.
     */
    public function updated(Order $order): void
    {
        // Check if status changed to pending_payment
        if ($order->isDirty('status')) {
            $originalStatus = OrderStatus::from($order->getOriginal('status')->value);
            $newStatus = $order->status;

            // If status changed to pending, decrease stock
            if ($newStatus === OrderStatus::PENDING_PAYMENT && $originalStatus !== OrderStatus::PENDING_PAYMENT) {
                $this->decreaseStock($order);
            }

            // If order was cancelled, restore stock
            if ($newStatus === OrderStatus::CANCELLED && $originalStatus !== OrderStatus::CANCELLED && $originalStatus !== OrderStatus::PENDING) {
                $this->restoreStock($order);
            }
        }
    }

    /**
     * Decrease stock for order items
     */
    private function decreaseStock(Order $order): void
    {
        foreach ($order->orderItems as $orderItem) {
            $songket = $orderItem->songket;

            if ($songket && $songket->stock_quantity >= $orderItem->quantity) {
                $songket->decrement('stock_quantity', $orderItem->quantity);

                Log::info("Stock decreased for Songket ID: {$songket->id}, Quantity: {$orderItem->quantity}, Remaining: {$songket->fresh()->stock_quantity}");
            } else {
                Log::warning("Insufficient stock for Songket ID: {$songket->id}, Required: {$orderItem->quantity}, Available: {$songket->stock_quantity}");
            }
        }
    }

    /**
     * Restore stock for cancelled orders
     */
    private function restoreStock(Order $order): void
    {
        foreach ($order->orderItems as $orderItem) {
            $songket = $orderItem->songket;

            if ($songket) {
                $songket->increment('stock_quantity', $orderItem->quantity);

                Log::info("Stock restored for Songket ID: {$songket->id}, Quantity: {$orderItem->quantity}, New Total: {$songket->fresh()->stock_quantity}");
            }
        }
    }

    /**
     * Handle the Order "deleted" event.
     */
    public function deleted(Order $order): void
    {
        // If order is deleted, restore stock
        if ($order->status === OrderStatus::PENDING) {
            $this->restoreStock($order);
        }
    }
}
