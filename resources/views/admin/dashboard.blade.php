<x-admin-layout>
    <div class="space-y-6">
        <!-- Header -->
        <div class="flex justify-between items-center">
            <div>
                <h1 class="text-2xl font-bold text-gray-900">Dashboard</h1>
                <p class="text-gray-600">Welcome back, {{ auth()->user()->name }} ({{ auth()->user()->role->label() }})
                </p>
            </div>
            <div class="text-sm text-gray-500">
                {{ now()->format('l, F j, Y') }}
            </div>
        </div>

        <!-- Stats Grid -->
        <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-4 gap-6">
            <!-- Total Orders -->
            <div class="bg-white rounded-lg shadow p-6">
                <div class="flex items-center">
                    <div class="p-2 bg-blue-100 rounded-lg">
                        <x-icon name="heroicon-o-shopping-bag" class="w-6 h-6 text-blue-600" />
                    </div>
                    <div class="ml-4">
                        <p class="text-sm font-medium text-gray-600">Total Orders</p>
                        <p class="text-2xl font-bold text-gray-900">{{ number_format($stats['total_orders']) }}</p>
                    </div>
                </div>
            </div>

            <!-- Pending Orders -->
            <div class="bg-white rounded-lg shadow p-6">
                <div class="flex items-center">
                    <div class="p-2 bg-yellow-100 rounded-lg">
                        <x-icon name="heroicon-o-clock" class="w-6 h-6 text-yellow-600" />
                    </div>
                    <div class="ml-4">
                        <p class="text-sm font-medium text-gray-600">Pending Orders</p>
                        <p class="text-2xl font-bold text-gray-900">{{ number_format($stats['pending_orders']) }}</p>
                    </div>
                </div>
            </div>

            <!-- Total Revenue -->
            <div class="bg-white rounded-lg shadow p-6">
                <div class="flex items-center">
                    <div class="p-2 bg-green-100 rounded-lg">
                        <x-icon name="heroicon-o-currency-dollar" class="w-6 h-6 text-green-600" />
                    </div>
                    <div class="ml-4">
                        <p class="text-sm font-medium text-gray-600">Total Revenue</p>
                        <p class="text-2xl font-bold text-gray-900">Rp {{ number_format($stats['total_revenue']) }}</p>
                    </div>
                </div>
            </div>

            <!-- Total Customers -->
            <div class="bg-white rounded-lg shadow p-6">
                <div class="flex items-center">
                    <div class="p-2 bg-purple-100 rounded-lg">
                        <x-icon name="heroicon-o-users" class="w-6 h-6 text-purple-600" />
                    </div>
                    <div class="ml-4">
                        <p class="text-sm font-medium text-gray-600">Total Customers</p>
                        <p class="text-2xl font-bold text-gray-900">{{ number_format($stats['total_customers']) }}</p>
                    </div>
                </div>
            </div>

            <!-- Admin-specific stats -->
            @if (auth()->user()->canAccess('manage_songkets'))
                <!-- Total Products -->
                <div class="bg-white rounded-lg shadow p-6">
                    <div class="flex items-center">
                        <div class="p-2 bg-indigo-100 rounded-lg">
                            <x-icon name="heroicon-o-cube" class="w-6 h-6 text-indigo-600" />
                        </div>
                        <div class="ml-4">
                            <p class="text-sm font-medium text-gray-600">Total Songket</p>
                            <p class="text-2xl font-bold text-gray-900">{{ number_format($stats['total_products']) }}
                            </p>
                        </div>
                    </div>
                </div>

                <!-- Active Products -->
                <div class="bg-white rounded-lg shadow p-6">
                    <div class="flex items-center">
                        <div class="p-2 bg-green-100 rounded-lg">
                            <x-icon name="heroicon-o-check-circle" class="w-6 h-6 text-green-600" />
                        </div>
                        <div class="ml-4">
                            <p class="text-sm font-medium text-gray-600">Active Songket</p>
                            <p class="text-2xl font-bold text-gray-900">{{ number_format($stats['active_products']) }}
                            </p>
                        </div>
                    </div>
                </div>

                <!-- Low Stock Products -->
                <div class="bg-white rounded-lg shadow p-6">
                    <div class="flex items-center">
                        <div class="p-2 bg-red-100 rounded-lg">
                            <x-icon name="heroicon-o-exclamation-triangle" class="w-6 h-6 text-red-600" />
                        </div>
                        <div class="ml-4">
                            <p class="text-sm font-medium text-gray-600">Low Stock Songket</p>
                            <p class="text-2xl font-bold text-gray-900">
                                {{ number_format($stats['low_stock_products']) }}</p>
                        </div>
                    </div>
                </div>
            @endif

            <!-- Cashier-specific stats -->
            @if (auth()->user()->canAccess('manage_payments'))
                <!-- Pending Payments -->
                <div class="bg-white rounded-lg shadow p-6">
                    <div class="flex items-center">
                        <div class="p-2 bg-orange-100 rounded-lg">
                            <x-icon name="heroicon-o-credit-card" class="w-6 h-6 text-orange-600" />
                        </div>
                        <div class="ml-4">
                            <p class="text-sm font-medium text-gray-600">Pending Payments</p>
                            <p class="text-2xl font-bold text-gray-900">{{ number_format($stats['pending_payments']) }}
                            </p>
                        </div>
                    </div>
                </div>

                <!-- Total Payments -->
                <div class="bg-white rounded-lg shadow p-6">
                    <div class="flex items-center">
                        <div class="p-2 bg-green-100 rounded-lg">
                            <x-icon name="heroicon-o-banknotes" class="w-6 h-6 text-green-600" />
                        </div>
                        <div class="ml-4">
                            <p class="text-sm font-medium text-gray-600">Total Payments</p>
                            <p class="text-2xl font-bold text-gray-900">Rp
                                {{ number_format($stats['total_payments']) }}</p>
                        </div>
                    </div>
                </div>
            @endif
        </div>

        <!-- Charts and Tables Row -->
        <div class="grid grid-cols-1 lg:grid-cols-2 gap-6">
            <!-- Monthly Revenue Chart -->
            @if (auth()->user()->canAccess('manage_orders') || auth()->user()->canAccess('view_all_reports'))
                <div class="bg-white rounded-lg shadow p-6">
                    <div class="flex justify-between items-center mb-4">
                        <h3 class="text-lg font-semibold text-gray-900">Monthly Revenue</h3>
                        <x-icon name="heroicon-o-chart-bar" class="w-5 h-5 text-gray-400" />
                    </div>
                    @if ($monthlyRevenue->count() > 0)
                        <div class="space-y-2">
                            @foreach ($monthlyRevenue->take(6) as $revenue)
                                <div class="flex justify-between items-center">
                                    <span class="text-sm text-gray-600">
                                        {{ DateTime::createFromFormat('!m', $revenue->month)->format('M') }}
                                        {{ $revenue->year }}
                                    </span>
                                    <span class="font-medium">Rp {{ number_format($revenue->revenue) }}</span>
                                </div>
                            @endforeach
                        </div>
                    @else
                        <p class="text-gray-500 text-center py-4">No revenue data available</p>
                    @endif
                </div>
            @endif

            <!-- Recent Orders -->
            @if (auth()->user()->canAccess('manage_orders') || auth()->user()->canAccess('view_all_reports'))
                <div class="bg-white rounded-lg shadow p-6">
                    <div class="flex justify-between items-center mb-4">
                        <h3 class="text-lg font-semibold text-gray-900">Recent Orders</h3>
                        @if (auth()->user()->canAccess('manage_orders'))
                            <a href="{{ route('admin.orders.index') }}"
                                class="text-blue-600 hover:text-blue-800 text-sm font-medium">
                                View All
                            </a>
                        @endif
                    </div>
                    @if ($recentOrders->count() > 0)
                        <div class="space-y-3">
                            @foreach ($recentOrders->take(5) as $order)
                                <div class="flex justify-between items-center p-3 bg-gray-50 rounded-lg">
                                    <div>
                                        <p class="font-medium text-sm">{{ $order->order_number }}</p>
                                        <p class="text-xs text-gray-600">{{ $order->customer_name }}</p>
                                    </div>
                                    <div class="text-right">
                                        <p class="font-medium text-sm">Rp {{ number_format($order->total_amount) }}</p>
                                        <span
                                            class="inline-flex items-center px-2 py-1 rounded-full text-xs font-medium {{ $order->status->color() }}">
                                            {{ $order->status->label() }}
                                        </span>
                                    </div>
                                </div>
                            @endforeach
                        </div>
                    @else
                        <p class="text-gray-500 text-center py-4">No recent orders</p>
                    @endif
                </div>
            @endif
        </div>

        <!-- Additional Sections -->
        <div class="grid grid-cols-1 lg:grid-cols-2 gap-6">
            <!-- Top Selling Products -->
            @if (auth()->user()->canAccess('manage_songkets') || auth()->user()->canAccess('view_all_reports'))
                <div class="bg-white rounded-lg shadow p-6">
                    <div class="flex justify-between items-center mb-4">
                        <h3 class="text-lg font-semibold text-gray-900">Top Selling Songket</h3>
                        <x-icon name="heroicon-o-fire" class="w-5 h-5 text-orange-500" />
                    </div>
                    @if ($topProducts->count() > 0)
                        <div class="space-y-3">
                            @foreach ($topProducts as $product)
                                <div class="flex justify-between items-center">
                                    <div class="flex items-center space-x-3">
                                        @if ($product->images && count($product->images) > 0)
                                            <img src="{{ $product->images[0] }}" alt="{{ $product->name }}"
                                                class="w-10 h-10 rounded-lg object-cover">
                                        @else
                                            <div
                                                class="w-10 h-10 bg-gray-200 rounded-lg flex items-center justify-center">
                                                <x-icon name="heroicon-o-photo" class="w-5 h-5 text-gray-400" />
                                            </div>
                                        @endif
                                        <div>
                                            <p class="font-medium text-sm">{{ $product->name }}</p>
                                            <p class="text-xs text-gray-600">{{ $product->category->name }}</p>
                                        </div>
                                    </div>
                                    <div class="text-right">
                                        <p class="font-medium text-sm">{{ $product->order_items_count }} sold</p>
                                        <p class="text-xs text-gray-600">Rp {{ number_format($product->base_price) }}
                                        </p>
                                    </div>
                                </div>
                            @endforeach
                        </div>
                    @else
                        <p class="text-gray-500 text-center py-4">No sales data available</p>
                    @endif
                </div>
            @endif

            <!-- Low Stock Alert -->
            @if (auth()->user()->canAccess('manage_songkets'))
                <div class="bg-white rounded-lg shadow p-6">
                    <div class="flex justify-between items-center mb-4">
                        <h3 class="text-lg font-semibold text-gray-900">Low Stock Alert</h3>
                        <x-icon name="heroicon-o-exclamation-triangle" class="w-5 h-5 text-red-500" />
                    </div>
                    @if ($lowStockProducts->count() > 0)
                        <div class="space-y-3">
                            @foreach ($lowStockProducts as $product)
                                <div
                                    class="flex justify-between items-center p-3 bg-red-50 rounded-lg border border-red-200">
                                    <div class="flex items-center space-x-3">
                                        @if ($product->images && count($product->images) > 0)
                                            <img src="{{ $product->images[0] }}" alt="{{ $product->name }}"
                                                class="w-10 h-10 rounded-lg object-cover">
                                        @else
                                            <div
                                                class="w-10 h-10 bg-gray-200 rounded-lg flex items-center justify-center">
                                                <x-icon name="heroicon-o-photo" class="w-5 h-5 text-gray-400" />
                                            </div>
                                        @endif
                                        <div>
                                            <p class="font-medium text-sm">{{ $product->name }}</p>
                                            <p class="text-xs text-gray-600">{{ $product->category->name }}</p>
                                        </div>
                                    </div>
                                    <div class="text-right">
                                        <span
                                            class="inline-flex items-center px-2 py-1 rounded-full text-xs font-medium bg-red-100 text-red-800">
                                            {{ $product->stock_quantity }} left
                                        </span>
                                        <p class="text-xs text-gray-600 mt-1">Rp
                                            {{ number_format($product->base_price) }}</p>
                                    </div>
                                </div>
                            @endforeach
                        </div>
                        <div class="mt-4">
                            <a href="{{ route('admin.songket.index', ['status' => 'active']) }}">
                                Manage Stock →
                            </a>
                        </div>
                    @else
                        <div class="text-center py-4">
                            <x-icon name="heroicon-o-check-circle" class="w-12 h-12 text-green-500 mx-auto mb-2" />
                            <p class="text-green-600 font-medium">All songket have sufficient stock</p>
                        </div>
                    @endif
                </div>
            @endif
        </div>

        <!-- Quick Actions -->
        @if (auth()->user()->canAccess('manage_songkets') ||
                auth()->user()->canAccess('manage_orders') ||
                auth()->user()->canAccess('manage_payments'))

            <div class="bg-white rounded-lg shadow p-6">
                <h3 class="text-lg font-semibold text-gray-900 mb-4">Quick Actions</h3>
                <div class="grid grid-cols-1 sm:grid-cols-2 lg:grid-cols-4 gap-4">
                    @if (auth()->user()->canAccess('manage_songkets'))
                        <a href="{{ route('admin.songket.create') }}"
                            class="flex items-center p-4 bg-blue-50 rounded-lg hover:bg-blue-100 transition-colors">
                            <x-icon name="heroicon-o-plus" class="w-6 h-6 text-blue-600 mr-3" />
                            <span class="font-medium text-blue-900">Add Product</span>
                        </a>

                        <a href="{{ route('admin.songket.export') }}"
                            class="flex items-center p-4 bg-green-50 rounded-lg hover:bg-green-100 transition-colors">
                            <x-icon name="heroicon-o-document-arrow-down" class="w-6 h-6 text-green-600 mr-3" />
                            <span class="font-medium text-green-900">Export Songket</span>
                        </a>
                    @endif

                    @if (auth()->user()->canAccess('manage_orders'))
                        <a href="{{ route('admin.orders.index', ['status' => 'pending']) }}"
                            class="flex items-center p-4 bg-yellow-50 rounded-lg hover:bg-yellow-100 transition-colors">
                            <x-icon name="heroicon-o-clock" class="w-6 h-6 text-yellow-600 mr-3" />
                            <span class="font-medium text-yellow-900">Pending Orders</span>
                        </a>

                        <a href="{{ route('admin.orders.export') }}"
                            class="flex items-center p-4 bg-purple-50 rounded-lg hover:bg-purple-100 transition-colors">
                            <x-icon name="heroicon-o-document-arrow-down" class="w-6 h-6 text-purple-600 mr-3" />
                            <span class="font-medium text-purple-900">Export Orders</span>
                        </a>
                    @endif

                    @if (auth()->user()->canAccess('manage_payments'))
                        <a href="{{ route('admin.payments.index', ['status' => 'waiting_verification']) }}"
                            class="flex items-center p-4 bg-orange-50 rounded-lg hover:bg-orange-100 transition-colors">
                            <x-icon name="heroicon-o-credit-card" class="w-6 h-6 text-orange-600 mr-3" />
                            <span class="font-medium text-orange-900">Verify Payments</span>
                        </a>

                        <a href="{{ route('admin.payments.export') }}"
                            class="flex items-center p-4 bg-indigo-50 rounded-lg hover:bg-indigo-100 transition-colors">
                            <x-icon name="heroicon-o-document-arrow-down" class="w-6 h-6 text-indigo-600 mr-3" />
                            <span class="font-medium text-indigo-900">Export Payments</span>
                        </a>
                    @endif
                </div>
            </div>
        @endif
    </div>
</x-admin-layout>
