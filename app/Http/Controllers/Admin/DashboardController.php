<?php

namespace App\Http\Controllers\Admin;

use App\Enums\OrderStatus;
use App\Enums\PaymentStatus;
use App\Http\Controllers\Controller;
use App\Models\Order;
use App\Models\Payment;
use App\Models\Songket;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;

class DashboardController extends Controller
{
    /**
     * Handle the incoming request.
     */
    public function __invoke(Request $request)
    {
        $user = Auth::user();

        // Base statistics available to all dashboard users
        $stats = [
            'total_orders' => Order::count(),
            'pending_orders' => Order::where('status', OrderStatus::PENDING_PAYMENT)->count(),
            'total_revenue' => Order::where('status', OrderStatus::COMPLETED)->sum('total_amount'),
            'total_customers' => User::whereNull('role')->count(),
        ];

        // Role-specific statistics
        if ($user->canAccess('manage_songkets')) {
            $stats['total_products'] = Songket::count();
            $stats['active_products'] = Songket::where('is_active', true)->count();
            $stats['low_stock_products'] = Songket::where('stock_quantity', '<=', 5)->count();
        }

        if ($user->canAccess('manage_payments')) {
            $stats['pending_payments'] = Payment::where('payment_status', PaymentStatus::WAITING_VERIFICATION)->count();
            $stats['total_payments'] = Payment::where('payment_status', PaymentStatus::VERIFIED)->sum('amount');
        }

        // Recent orders (visible to cashiers and owners)
        $recentOrders = collect();
        if ($user->canAccess('manage_orders') || $user->canAccess('view_all_reports')) {
            $recentOrders = Order::with(['user', 'payment'])
                ->orderBy('created_at', 'desc')
                ->limit(10)
                ->get();
        }

        // Monthly revenue chart data (visible to cashiers and owners)
        $monthlyRevenue = collect();
        if ($user->canAccess('manage_orders') || $user->canAccess('view_all_reports')) {
            $monthlyRevenue = Order::where('status', OrderStatus::COMPLETED)
                ->where('created_at', '>=', now()->subMonths(12))
                ->select(
                    DB::raw('YEAR(created_at) as year'),
                    DB::raw('MONTH(created_at) as month'),
                    DB::raw('SUM(total_amount) as revenue')
                )
                ->groupBy('year', 'month')
                ->orderBy('year', 'desc')
                ->orderBy('month', 'desc')
                ->limit(12)
                ->get()
                ->reverse();
        }

        // Top selling songkets (visible to admins and owners)
        $topProducts = collect();
        if ($user->canAccess('manage_songkets') || $user->canAccess('view_all_reports')) {
            $topProducts = Songket::withCount(['orderItems' => function ($query) {
                $query->whereHas('order', function ($q) {
                    $q->where('status', OrderStatus::COMPLETED);
                });
            }])
                ->orderBy('order_items_count', 'desc')
                ->limit(5)
                ->get();
        }

        // Low stock products (visible to admins)
        $lowStockProducts = collect();
        if ($user->canAccess('manage_songkets')) {
            $lowStockProducts = Songket::where('stock_quantity', '<=', 5)
                ->where('is_active', true)
                ->orderBy('stock_quantity', 'asc')
                ->limit(10)
                ->get();
        }

        return view('admin.dashboard', compact(
            'stats',
            'recentOrders',
            'monthlyRevenue',
            'topProducts',
            'lowStockProducts'
        ));
    }
}
