<?php

namespace App\Http\Controllers\Order;

use App\Enums\OrderStatus;
use App\Enums\PaymentMethod;
use App\Enums\PaymentStatus;
use App\Http\Controllers\Controller;
use App\Models\Order;
use App\Models\Payment;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Gate;
use Illuminate\Validation\Rule;

class ProcessPaymentController extends Controller
{
    /**
     * Handle the incoming request.
     */
    public function __invoke(Request $request, Order $order)
    {
        Gate::authorize('update', $order);

        $request->validate([
            'payment_method'    => ['required', Rule::enum(PaymentMethod::class)],
            'payment_proof'     => [
                'nullable',
                'image',
                'max:2048', // 2MB max file size
                Rule::requiredIf(fn() => PaymentMethod::from($request->payment_method)->requiresProof()),
                'mimes:png,jpg,jpeg,webp', // Allowed file types
            ],
        ]);

        $paymentMethod = PaymentMethod::from($request->payment_method);

        // Handle payment proof upload
        $paymentProofPath = null;
        if ($request->hasFile('payment_proof') && $paymentMethod->requiresProof()) {
            $paymentProofPath = $request->file('payment_proof')->store('payment-proofs', 'public');
        }

        DB::beginTransaction();

        try {
            // Delete existing payment if any
            if ($order->payment) {
                $order->payment->delete();
            }
            // Create payment record
            $payment = Payment::create([
                'order_id'                  => $order->id,
                'payment_method'            => $paymentMethod,
                'payment_status'            => PaymentStatus::WAITING_VERIFICATION,
                'amount'                    => $order->total_amount,
                'payment_proof'             => $paymentProofPath,
                'payment_date'              => now(),
            ]);

            // Update order status
            $order->update([
                'status' => $paymentMethod === PaymentMethod::PAY_IN_STORE
                    ? OrderStatus::PENDING
                    : OrderStatus::PENDING_PAYMENT,
            ]);

            DB::commit();
            return redirect()->route('checkout.confirmation', $order)->with('success', 'Payment information submitted successfully!');
        } catch (\Exception $e) {
            DB::rollback();
            return back()->with('error', 'Something went wrong while processing your payment. Please try again.');
        }
    }
}
