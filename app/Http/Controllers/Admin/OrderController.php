<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Order;
use App\Enums\OrderStatus;
use App\Rules\StatusCanBeChanged;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Storage;
use Illuminate\Validation\Rule;
use Symfony\Component\HttpFoundation\StreamedResponse;

class OrderController extends Controller
{
    public function index(Request $request)
    {
        if (!Auth::user()->canAccess('manage_orders')) {
            abort(403, 'Access denied.');
        }

        $query = Order::with(['user', 'orderItems.songket', 'payment'])->withCount('orderItems'); // adds order_items_count;

        // Search by order number or customer name
        if ($request->filled('search')) {
            $search = $request->search;
            $query->where(function ($q) use ($search) {
                $q->where('order_number', 'like', "%{$search}%")
                    ->orWhereHas('user', function ($userQuery) use ($search) {
                        $userQuery->where('name', 'like', "%{$search}%")
                            ->orWhere('email', 'like', "%{$search}%");
                    });
            });
        }

        // Filter by status
        if ($request->filled('status')) {
            $query->where('status', $request->status);
        }

        // Filter by date range
        if ($request->filled('date_from')) {
            $query->whereDate('created_at', '>=', $request->date_from);
        }

        if ($request->filled('date_to')) {
            $query->whereDate('created_at', '<=', $request->date_to);
        }

        $orders = $query->orderBy('created_at', 'desc')->paginate(20);

        return view('admin.orders.index', compact('orders'));
    }

    public function show(Order $order)
    {
        if (!Auth::user()->canAccess('manage_orders')) {
            abort(403, 'Access denied.');
        }

        $order->load(['user', 'orderItems.songket', 'payment']);
        return view('admin.orders.show', compact('order'));
    }

    public function destroy(Order $order)
    {
        if (!Auth::user()->canAccess('manage_orders')) {
            abort(403, 'Access denied.');
        }

        // Check if order can be deleted
        if ($order->status !== OrderStatus::PENDING && $order->status !== OrderStatus::CANCELLED) {
            return redirect()->back()->with('error', 'Hanya pesanan dengan status "Pending" atau "Cancelled" yang dapat dihapus.');
        }

        // Delete payment proof file if exists
        if ($order->payment && $order->payment->payment_proof) {
            Storage::disk('public')->delete($order->payment->payment_proof);
        }

        $order->delete();

        return redirect()->route('admin.orders.index')->with('success', 'Pesanan berhasil dihapus.');
    }

    public function updateStatus(Request $request, Order $order)
    {
        if (!Auth::user()->canAccess('manage_orders')) {
            abort(403, 'Access denied.');
        }

        $request->validate([
            'status' => ['required', Rule::enum(OrderStatus::class), new StatusCanBeChanged($order->status, 'order')],
        ], [
            'status.required' => 'Status pesanan harus dipilih.',
        ]);

        $oldStatus = $order->status->label();
        $order->update(['status' => $request->status]);

        $message = "Status pesanan berhasil diubah dari {$oldStatus} ke {$order->status->label()}.";

        return redirect()->back()->with('success', $message);
    }

    public function export(Request $request)
    {
        if (!Auth::user()->canAccess('export_orders')) {
            abort(403, 'Access denied.');
        }

        $query = Order::with(['user', 'orderItems.songket', 'payment']);

        // Apply same filters as index
        if ($request->filled('search')) {
            $search = $request->search;
            $query->where(function ($q) use ($search) {
                $q->where('order_number', 'like', "%{$search}%")
                    ->orWhereHas('user', function ($userQuery) use ($search) {
                        $userQuery->where('name', 'like', "%{$search}%")
                            ->orWhere('email', 'like', "%{$search}%");
                    });
            });
        }

        if ($request->filled('status')) {
            $query->where('status', $request->status);
        }

        if ($request->filled('date_from')) {
            $query->whereDate('created_at', '>=', $request->date_from);
        }

        if ($request->filled('date_to')) {
            $query->whereDate('created_at', '<=', $request->date_to);
        }

        $orders = $query->orderBy('created_at', 'desc')->get();

        $response = new StreamedResponse(function () use ($orders) {
            $handle = fopen('php://output', 'w');

            // Add BOM for proper UTF-8 encoding in Excel
            fprintf($handle, chr(0xEF) . chr(0xBB) . chr(0xBF));

            // Add CSV headers
            fputcsv($handle, [
                'No. Pesanan',
                'Nama Pelanggan',
                'Email Pelanggan',
                'Total Harga (Rp)',
                'Status',
                'Tanggal Pesanan',
                'Jumlah Item'
            ]);

            // Add data rows
            foreach ($orders as $order) {
                fputcsv($handle, [
                    $order->order_number,
                    $order->user->name,
                    $order->user->email,
                    number_format($order->total_amount, 0, ',', '.'),
                    $order->status->label(),
                    $order->created_at->format('d/m/Y H:i:s'),
                    $order->orderItems->sum('quantity')
                ]);
            }

            fclose($handle);
        });

        $response->headers->set('Content-Type', 'text/csv; charset=UTF-8');
        $response->headers->set('Content-Disposition', 'attachment; filename="data-pesanan-' . date('Y-m-d') . '.csv"');

        return $response;
    }
}
