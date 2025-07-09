<x-app-layout>
    <x-slot name="title">My Orders - Palembang Songket Store</x-slot>

    <div class="min-h-screen bg-gradient-to-br from-amber-50 via-orange-50 to-yellow-50">
        <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8 py-8">
            <!-- Header -->
            <div class="mb-8">
                <h1 class="text-3xl md:text-4xl font-bold text-gray-900 font-serif mb-4 flex items-center">
                    <x-icon name="heroicon-o-shopping-bag" class="h-8 w-8 mr-3 text-amber-600" />
                    My Orders
                </h1>
                <p class="text-lg text-gray-600">Track and manage your songket orders</p>
            </div>

            @if ($orders->count() > 0)
                <div class="space-y-6">
                    @foreach ($orders as $order)
                        <div
                            class="bg-white rounded-2xl shadow-lg border border-gray-100 overflow-hidden hover:shadow-xl transition-shadow duration-300">
                            <!-- Order Header -->
                            <div class="bg-gradient-to-r from-amber-500 to-orange-500 p-6 text-white">
                                <div class="flex flex-col sm:flex-row sm:items-center sm:justify-between">
                                    <div class="mb-4 sm:mb-0">
                                        <h2 class="text-xl font-bold flex items-center">
                                            <x-icon name="heroicon-o-document-text" class="h-5 w-5 mr-2" />
                                            Order #{{ $order->order_number }}
                                        </h2>
                                        <p class="text-amber-100 flex items-center mt-1">
                                            <x-icon name="heroicon-o-calendar" class="h-4 w-4 mr-1" />
                                            {{ $order->created_at->format('F j, Y \a\t g:i A') }}
                                        </p>
                                    </div>
                                    <div class="flex flex-col sm:items-end space-y-2">
                                        <div
                                            class="inline-flex items-center px-3 py-1 rounded-full text-sm font-medium bg-white/20 text-white">
                                            @switch($order->status->value)
                                                @case('pending')
                                                    <x-icon name="heroicon-o-clock" class="h-4 w-4 mr-1" />
                                                @break

                                                @case('pending_payment')
                                                    <x-icon name="heroicon-o-credit-card" class="h-4 w-4 mr-1" />
                                                @break

                                                @case('processing')
                                                    <x-icon name="heroicon-o-cog-6-tooth" class="h-4 w-4 mr-1" />
                                                @break

                                                @case('ready_for_pickup')
                                                    <x-icon name="heroicon-o-check-circle" class="h-4 w-4 mr-1" />
                                                @break

                                                @case('completed')
                                                    <x-icon name="heroicon-o-check-badge" class="h-4 w-4 mr-1" />
                                                @break

                                                @case('canceled')
                                                    <x-icon name="heroicon-o-x-circle" class="h-4 w-4 mr-1" />
                                                @break

                                                @default
                                                    <x-icon name="heroicon-o-question-mark-circle" class="h-4 w-4 mr-1" />
                                            @endswitch
                                            {{ $order->status->label() }}
                                        </div>
                                        <div class="text-right">
                                            <p class="text-2xl font-bold">{{ $order->formatted_total_amount }}</p>
                                            <p class="text-amber-100 text-sm">{{ $order->orderItems->sum('quantity') }}
                                                items</p>
                                        </div>
                                    </div>
                                </div>
                            </div>

                            <!-- Order Content -->
                            <div class="p-6">
                                <div class="grid grid-cols-1 lg:grid-cols-3 gap-6">
                                    <!-- Order Items Preview -->
                                    <div class="lg:col-span-2">
                                        <h3 class="font-semibold text-gray-900 mb-3 flex items-center">
                                            <x-icon name="heroicon-o-cube" class="h-4 w-4 mr-2 text-amber-600" />
                                            Items Ordered
                                        </h3>
                                        <div class="space-y-3">
                                            @foreach ($order->orderItems->take(3) as $item)
                                                <div class="flex items-center space-x-3 p-3 bg-gray-50 rounded-lg">
                                                    <div
                                                        class="w-12 h-12 bg-amber-100 rounded-lg flex items-center justify-center">
                                                        <x-icon name="heroicon-o-sparkles"
                                                            class="h-6 w-6 text-amber-600" />
                                                    </div>
                                                    <div class="flex-1">
                                                        <p class="font-medium text-gray-900">{{ $item->songket->name }}
                                                        </p>
                                                        <div class="flex items-center space-x-3 text-sm text-gray-500">
                                                            @if ($item->selected_color)
                                                                <span class="flex items-center">
                                                                    <x-icon name="heroicon-o-swatch"
                                                                        class="h-3 w-3 mr-1" />
                                                                    {{ $item->selected_color }}
                                                                </span>
                                                            @endif
                                                            <span class="flex items-center">
                                                                <x-icon name="heroicon-o-hashtag"
                                                                    class="h-3 w-3 mr-1" />
                                                                {{ $item->quantity }}x
                                                            </span>
                                                        </div>
                                                    </div>
                                                    <div class="text-right">
                                                        <p class="font-semibold text-gray-900">
                                                            {{ $item->formatted_total_price }}</p>
                                                    </div>
                                                </div>
                                            @endforeach
                                            @if ($order->orderItems->count() > 3)
                                                <p class="text-sm text-gray-500 text-center py-2">
                                                    <x-icon name="heroicon-o-ellipsis-horizontal"
                                                        class="h-4 w-4 inline mr-1" />
                                                    and {{ $order->orderItems->count() - 3 }} more items
                                                </p>
                                            @endif
                                        </div>
                                    </div>

                                    <!-- Payment Status & Actions -->
                                    <div class="space-y-4">
                                        <!-- Payment Status -->
                                        @if (!$order->payment)
                                            <div class="bg-red-50 border border-red-200 rounded-lg p-4">
                                                <div class="flex items-center mb-2">
                                                    <x-icon name="heroicon-o-exclamation-triangle"
                                                        class="h-5 w-5 text-red-600 mr-2" />
                                                    <h4 class="font-semibold text-red-900">Payment Required</h4>
                                                </div>
                                                <p class="text-sm text-red-700 mb-3">Complete your payment to process
                                                    this order</p>
                                                <a href="{{ route('checkout.payment', $order) }}"
                                                    class="inline-flex items-center px-4 py-2 bg-red-600 hover:bg-red-700 text-white text-sm font-medium rounded-lg transition-colors">
                                                    <x-icon name="heroicon-o-credit-card" class="h-4 w-4 mr-2" />
                                                    Continue Payment
                                                </a>
                                            </div>
                                        @else
                                            <div class="bg-gray-50 border border-gray-200 rounded-lg p-4">
                                                <div class="flex items-center justify-between mb-2">
                                                    <h4 class="font-semibold text-gray-900 flex items-center">
                                                        <x-icon name="heroicon-o-credit-card"
                                                            class="h-4 w-4 mr-2 text-amber-600" />
                                                        Payment
                                                    </h4>
                                                    <span
                                                        class="inline-flex items-center px-2 py-1 rounded-full text-xs font-medium {{ $order->payment->payment_status->color() === 'green' ? 'bg-green-100 text-green-800' : ($order->payment->payment_status->color() === 'yellow' ? 'bg-yellow-100 text-yellow-800' : 'bg-red-100 text-red-800') }}">
                                                        @switch($order->payment->payment_status->value)
                                                            @case('paid')
                                                                <x-icon name="heroicon-o-check-circle" class="h-3 w-3 mr-1" />
                                                            @break

                                                            @case('waiting_verification')
                                                                <x-icon name="heroicon-o-clock" class="h-3 w-3 mr-1" />
                                                            @break

                                                            @case('failed')
                                                                <x-icon name="heroicon-o-x-circle" class="h-3 w-3 mr-1" />
                                                            @break

                                                            @default
                                                                <x-icon name="heroicon-o-question-mark-circle"
                                                                    class="h-3 w-3 mr-1" />
                                                        @endswitch
                                                        {{ $order->payment->payment_status->label() }}
                                                    </span>
                                                </div>
                                                <p class="text-sm text-gray-600">
                                                    {{ $order->payment->payment_method->label() }}</p>
                                                @if ($order->payment->payment_status->value === 'waiting_verification')
                                                    <a href="{{ route('checkout.payment', $order) }}"
                                                        class="inline-flex items-center px-3 py-1 bg-amber-100 hover:bg-amber-200 text-amber-800 text-xs font-medium rounded-lg transition-colors mt-2">
                                                        <x-icon name="heroicon-o-arrow-path" class="h-3 w-3 mr-1" />
                                                        Update Payment
                                                    </a>
                                                @endif
                                            </div>
                                        @endif

                                        <!-- Customer Info -->
                                        <div class="bg-gray-50 border border-gray-200 rounded-lg p-4">
                                            <h4 class="font-semibold text-gray-900 mb-3 flex items-center">
                                                <x-icon name="heroicon-o-user" class="h-4 w-4 mr-2 text-amber-600" />
                                                Customer
                                            </h4>
                                            <div class="space-y-2 text-sm">
                                                <p class="flex items-center text-gray-600">
                                                    <x-icon name="heroicon-o-user-circle" class="h-3 w-3 mr-2" />
                                                    {{ $order->customer_name }}
                                                </p>
                                                <p class="flex items-center text-gray-600">
                                                    <x-icon name="heroicon-o-phone" class="h-3 w-3 mr-2" />
                                                    {{ $order->customer_phone }}
                                                </p>
                                            </div>
                                        </div>

                                        <!-- Actions -->
                                        <div class="flex flex-col space-y-2">
                                            <a href="{{ route('orders.show', $order) }}"
                                                class="inline-flex items-center justify-center px-4 py-2 bg-amber-600 hover:bg-amber-700 text-white text-sm font-medium rounded-lg transition-colors">
                                                <x-icon name="heroicon-o-eye" class="h-4 w-4 mr-2" />
                                                View Details
                                            </a>
                                            @if ($order->status->value === 'ready_for_pickup')
                                                <div
                                                    class="inline-flex items-center justify-center px-4 py-2 bg-green-100 text-green-800 text-sm font-medium rounded-lg">
                                                    <x-icon name="heroicon-o-check-circle" class="h-4 w-4 mr-2" />
                                                    Ready for Pickup
                                                </div>
                                            @endif
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                    @endforeach
                </div>

                <!-- Pagination -->
                @if ($orders->hasPages())
                    <div class="mt-8">
                        {{ $orders->links() }}
                    </div>
                @endif
            @else
                <!-- Empty State -->
                <div class="bg-white rounded-2xl shadow-lg border border-gray-100 p-12 text-center">
                    <div class="w-24 h-24 bg-gray-100 rounded-full flex items-center justify-center mx-auto mb-6">
                        <x-icon name="heroicon-o-shopping-bag" class="h-12 w-12 text-gray-400" />
                    </div>
                    <h2 class="text-2xl font-bold text-gray-900 mb-4">No Orders Yet</h2>
                    <p class="text-gray-600 mb-8 max-w-md mx-auto">You haven't placed any orders yet. Start shopping to
                        see your orders here.</p>
                    <a href="{{ route('catalog.index') }}"
                        class="inline-flex items-center px-6 py-3 bg-gradient-to-r from-amber-500 to-orange-500 hover:from-amber-600 hover:to-orange-600 text-white font-bold rounded-xl transition-all duration-300 shadow-lg hover:shadow-xl transform hover:-translate-y-0.5">
                        <x-icon name="heroicon-o-shopping-cart" class="h-5 w-5 mr-2" />
                        Start Shopping
                    </a>
                </div>
            @endif
        </div>
    </div>
</x-app-layout>
