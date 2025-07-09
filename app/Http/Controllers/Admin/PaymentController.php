<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Payment;
use App\Enums\PaymentStatus;
use App\Enums\OrderStatus;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Symfony\Component\HttpFoundation\StreamedResponse;

class PaymentController extends Controller
{
    public function index(Request $request)
    {
        if (!Auth::user()->canAccess('manage_payments')) {
            abort(403, 'Access denied.');
        }

        $query = Payment::with(['order.user']);

        // Search by payment reference or customer name
        if ($request->filled('search')) {
            $search = $request->search;
            $query->where(function ($q) use ($search) {
                $q->where('payment_reference', 'like', "%{$search}%")
                    ->orWhereHas('order.user', function ($userQuery) use ($search) {
                        $userQuery->where('name', 'like', "%{$search}%")
                            ->orWhere('email', 'like', "%{$search}%");
                    });
            });
        }

        // Filter by status
        if ($request->filled('status')) {
            $query->where('payment_status', $request->status);
        }

        // Filter by payment method
        if ($request->filled('method')) {
            $query->where('payment_method', $request->method);
        }

        // Filter by date range
        if ($request->filled('date_from')) {
            $query->whereDate('created_at', '>=', $request->date_from);
        }

        if ($request->filled('date_to')) {
            $query->whereDate('created_at', '<=', $request->date_to);
        }

        $payments = $query->orderBy('created_at', 'desc')->paginate(20);

        return view('admin.payments.index', compact('payments'));
    }

    public function show(Payment $payment)
    {
        if (!Auth::user()->canAccess('manage_payments')) {
            abort(403, 'Access denied.');
        }

        $payment->load(['order.user', 'order.orderItems.songket']);
        return view('admin.payments.show', compact('payment'));
    }

    public function verify(Request $request, Payment $payment)
    {
        if (!Auth::user()->canAccess('manage_payments')) {
            abort(403, 'Access denied.');
        }

        if ($payment->status === PaymentStatus::VERIFIED) {
            return redirect()->back()->with('error', 'Pembayaran ini sudah diverifikasi atau ditolak sebelumnya.');
        }

        // Validate the request to ensure 'verification_action' is present and valid
        $validated = $request->validate([
            'action' => 'required|in:approve,reject',
        ]);

        if ($validated['action'] === 'approve') {
            $payment->update([
                'payment_status' => PaymentStatus::VERIFIED,
                'verified_at' => now(),
                'verified_by' => Auth::id(),
            ]);

            $payment->order->update([
                'status' => OrderStatus::READY_FOR_PICKUP
            ]);

            return redirect()->back()->with('success', 'Pembayaran berhasil diverifikasi dan pesanan dapat diambil');
        } else {
            $payment->update([
                'payment_status' => PaymentStatus::FAILED,
                'verified_at' => now(),
                'verified_by' => Auth::id(),
            ]);

            // Optionally, you can also update the order status if needed
            $payment->order->update([
                'status' => OrderStatus::CANCELLED
            ]);

            return redirect()->back()->with('success', 'Pembayaran berhasil ditolak.');
        }
    }

    public function export(Request $request)
    {
        if (!Auth::user()->canAccess('export_payments')) {
            abort(403, 'Access denied.');
        }

        $query = Payment::with(['order.user']);

        // Apply same filters as index
        if ($request->filled('search')) {
            $search = $request->search;
            $query->where(function ($q) use ($search) {
                $q->where('payment_reference', 'like', "%{$search}%")
                    ->orWhereHas('order.user', function ($userQuery) use ($search) {
                        $userQuery->where('name', 'like', "%{$search}%")
                            ->orWhere('email', 'like', "%{$search}%");
                    });
            });
        }

        if ($request->filled('status')) {
            $query->where('status', $request->status);
        }

        if ($request->filled('method')) {
            $query->where('method', $request->method);
        }

        if ($request->filled('date_from')) {
            $query->whereDate('created_at', '>=', $request->date_from);
        }

        if ($request->filled('date_to')) {
            $query->whereDate('created_at', '<=', $request->date_to);
        }

        $payments = $query->orderBy('created_at', 'desc')->get();

        $response = new StreamedResponse(function () use ($payments) {
            $handle = fopen('php://output', 'w');

            // Add BOM for proper UTF-8 encoding in Excel
            fprintf($handle, chr(0xEF) . chr(0xBB) . chr(0xBF));

            // Add CSV headers
            fputcsv($handle, [
                'Referensi Pembayaran',
                'No. Pesanan',
                'Nama Pelanggan',
                'Jumlah (Rp)',
                'Metode Pembayaran',
                'Status',
                'Tanggal Pembayaran',
                'Tanggal Verifikasi'
            ]);

            // Add data rows
            foreach ($payments as $payment) {
                fputcsv($handle, [
                    $payment->payment_reference,
                    $payment->order->order_number,
                    $payment->order->user->name,
                    number_format($payment->amount, 0, ',', '.'),
                    $payment->method->label(),
                    $payment->status->label(),
                    $payment->created_at->format('d/m/Y H:i:s'),
                    $payment->verified_at ? $payment->verified_at->format('d/m/Y H:i:s') : '-'
                ]);
            }

            fclose($handle);
        });

        $response->headers->set('Content-Type', 'text/csv; charset=UTF-8');
        $response->headers->set('Content-Disposition', 'attachment; filename="data-pembayaran-' . date('Y-m-d') . '.csv"');

        return $response;
    }
}
