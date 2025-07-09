<x-app-layout>
    <x-slot name="title">Order #{{ $order->order_number }} - Palembang Songket Store</x-slot>

    <div class="min-h-screen bg-gradient-to-br from-amber-50 via-orange-50 to-yellow-50">
        <div class="max-w-6xl mx-auto px-4 sm:px-6 lg:px-8 py-8">
            <!-- Header -->
            <div class="mb-8">
                <div class="flex items-center mb-4">
                    <a href="{{ route('orders.index') }}" class="mr-4 p-2 hover:bg-white rounded-lg transition-colors">
                        <x-icon name="heroicon-o-arrow-left" class="h-5 w-5 text-gray-600" />
                    </a>
                    <h1 class="text-3xl md:text-4xl font-bold text-gray-900 font-serif flex items-center">
                        <x-icon name="heroicon-o-document-text" class="h-8 w-8 mr-3 text-amber-600" />
                        Order #{{ $order->order_number }}
                    </h1>
                </div>
                <p class="text-lg text-gray-600">Placed on {{ $order->created_at->format('F j, Y \a\t g:i A') }}</p>
            </div>

            <!-- Payment Alert -->
            @if (!$order->payment)
                <div class="bg-red-50 border border-red-200 rounded-2xl p-6 mb-8">
                    <div class="flex items-center">
                        <x-icon name="heroicon-o-exclamation-triangle" class="h-8 w-8 text-red-600 mr-4" />
                        <div class="flex-1">
                            <h3 class="text-lg font-semibold text-red-900">Payment Required</h3>
                            <p class="text-red-700 mt-1">Your order is waiting for payment. Complete your payment to
                                process this order.</p>
                        </div>
                        <a href="{{ route('checkout.payment', $order) }}"
                            class="bg-red-600 hover:bg-red-700 text-white px-6 py-3 rounded-xl font-semibold transition-colors flex items-center">
                            <x-icon name="heroicon-o-credit-card" class="h-5 w-5 mr-2" />
                            Continue Payment
                        </a>
                    </div>
                </div>
            @endif

            <!-- Cancellation Alert -->
            @if ($order->status->value === 'canceled')
                <div class="bg-gray-50 border border-gray-200 rounded-2xl p-6 mb-8">
                    <div class="flex items-center">
                        <x-icon name="heroicon-o-x-circle" class="h-8 w-8 text-gray-600 mr-4" />
                        <div>
                            <h3 class="text-lg font-semibold text-gray-900">Order Cancelled</h3>
                            <p class="text-gray-700 mt-1">This order has been cancelled. If you paid for this order, a
                                refund will be processed within 3-5 business days.</p>
                        </div>
                    </div>
                </div>
            @endif

            <div class="grid grid-cols-1 lg:grid-cols-3 gap-8">
                <!-- Main Content -->
                <div class="lg:col-span-2 space-y-8">
                    <!-- Order Status Timeline -->
                    <div class="bg-white rounded-2xl shadow-lg border border-gray-100 p-8">
                        <h2 class="text-2xl font-bold text-gray-900 mb-6 flex items-center">
                            <x-icon name="heroicon-o-clock" class="h-6 w-6 mr-3 text-amber-600" />
                            Order Status
                        </h2>

                        @php
                            $statuses = [
                                'pending' => 'Order Placed',
                                'pending_payment' => 'Payment Pending',
                                'processing' => 'Processing',
                                'ready_for_pickup' => 'Ready for Pickup',
                                'completed' => 'Completed',
                            ];

                            $statusOrder = array_keys($statuses);
                            $currentStatusIndex = array_search($order->status->value, $statusOrder);
                            $progressPercentage =
                                $currentStatusIndex !== false
                                    ? (($currentStatusIndex + 1) / count($statusOrder)) * 100
                                    : 0;

                            // Handle cancelled status
                            if ($order->status->value === 'canceled') {
                                $progressPercentage = 0;
                            }
                        @endphp

                        <!-- Progress Bar -->
                        <div class="mb-8">
                            <div class="w-full bg-gray-200 rounded-full h-2">
                                <div class="bg-gradient-to-r {{ $order->status->value === 'canceled' ? 'from-red-500 to-red-600' : 'from-amber-500 to-orange-500' }} h-2 rounded-full transition-all duration-500"
                                    style="width: {{ $progressPercentage }}%"></div>
                            </div>
                            <p class="text-sm text-gray-600 mt-2">
                                @if ($order->status->value === 'canceled')
                                    Order Cancelled
                                @else
                                    {{ round($progressPercentage) }}% Complete
                                @endif
                            </p>
                        </div>

                        <!-- Status Timeline -->
                        <div class="space-y-4">
                            @if ($order->status->value === 'canceled')
                                <div class="flex items-center">
                                    <div
                                        class="flex-shrink-0 w-8 h-8 rounded-full flex items-center justify-center bg-red-500 text-white">
                                        <x-icon name="heroicon-o-x-mark" class="h-4 w-4" />
                                    </div>
                                    <div class="ml-4 flex-1">
                                        <p class="font-semibold text-red-600">Order Cancelled</p>
                                        <p class="text-sm text-gray-600">This order has been cancelled</p>
                                    </div>
                                </div>
                            @else
                                @foreach ($statuses as $statusKey => $statusLabel)
                                    @php
                                        $statusIndex = array_search($statusKey, $statusOrder);
                                        $isCompleted = $statusIndex <= $currentStatusIndex;
                                        $isCurrent = $statusKey === $order->status->value;
                                    @endphp

                                    <div class="flex items-center">
                                        <div
                                            class="flex-shrink-0 w-8 h-8 rounded-full flex items-center justify-center {{ $isCompleted ? 'bg-green-500 text-white' : ($isCurrent ? 'bg-amber-500 text-white' : 'bg-gray-200 text-gray-500') }}">
                                            @if ($isCompleted && !$isCurrent)
                                                <x-icon name="heroicon-o-check" class="h-4 w-4" />
                                            @else
                                                <span class="text-sm font-bold">{{ $statusIndex + 1 }}</span>
                                            @endif
                                        </div>
                                        <div class="ml-4 flex-1">
                                            <p
                                                class="font-semibold {{ $isCurrent ? 'text-amber-600' : ($isCompleted ? 'text-green-600' : 'text-gray-500') }}">
                                                {{ $statusLabel }}
                                            </p>
                                            @if ($isCurrent)
                                                <p class="text-sm text-gray-600">Current status</p>
                                            @elseif($isCompleted)
                                                <p class="text-sm text-gray-600">Completed</p>
                                            @endif
                                        </div>
                                    </div>
                                @endforeach
                            @endif
                        </div>
                    </div>

                    <!-- Order Items -->
                    <div class="bg-white rounded-2xl shadow-lg border border-gray-100 p-8">
                        <h2 class="text-2xl font-bold text-gray-900 mb-6 flex items-center">
                            <x-icon name="heroicon-o-shopping-bag" class="h-6 w-6 mr-3 text-amber-600" />
                            Order Items
                        </h2>
                        <div class="space-y-6">
                            @foreach ($order->orderItems as $item)
                                <div class="flex items-center space-x-4 p-6 bg-gray-50 rounded-xl">
                                    <div class="w-20 h-20 bg-amber-100 rounded-xl flex items-center justify-center">
                                        <x-icon name="heroicon-o-sparkles" class="h-10 w-10 text-amber-600" />
                                    </div>
                                    <div class="flex-1">
                                        <h3 class="text-lg font-semibold text-gray-900">{{ $item->songket->name }}</h3>
                                        <p class="text-gray-600">{{ $item->songket->category->name }}</p>
                                        <div class="flex items-center space-x-4 text-sm text-gray-500 mt-2">
                                            @if ($item->selected_color)
                                                <span class="flex items-center">
                                                    <x-icon name="heroicon-o-swatch" class="h-4 w-4 mr-1" />
                                                    Color: {{ $item->selected_color }}
                                                </span>
                                            @endif
                                            @if ($item->selected_size)
                                                <span class="flex items-center">
                                                    <x-icon name="heroicon-o-squares-2x2" class="h-4 w-4 mr-1" />
                                                    Size: {{ $item->selected_size }}
                                                </span>
                                            @endif
                                            <span class="flex items-center">
                                                <x-icon name="heroicon-o-hashtag" class="h-4 w-4 mr-1" />
                                                Quantity: {{ $item->quantity }}
                                            </span>
                                        </div>
                                    </div>
                                    <div class="text-right">
                                        <p class="text-lg font-bold text-gray-900">{{ $item->formatted_total_price }}
                                        </p>
                                        <p class="text-sm text-gray-600">{{ $item->formatted_price }} each</p>
                                    </div>
                                </div>
                            @endforeach
                        </div>
                    </div>

                    <!-- Customer Information -->
                    <div class="bg-white rounded-2xl shadow-lg border border-gray-100 p-8">
                        <h2 class="text-2xl font-bold text-gray-900 mb-6 flex items-center">
                            <x-icon name="heroicon-o-user" class="h-6 w-6 mr-3 text-amber-600" />
                            Customer Information
                        </h2>
                        <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
                            <div class="space-y-4">
                                <div class="flex items-start space-x-3">
                                    <x-icon name="heroicon-o-user-circle" class="h-5 w-5 text-gray-400 mt-1" />
                                    <div>
                                        <p class="text-sm text-gray-600">Full Name</p>
                                        <p class="font-semibold text-gray-900">{{ $order->customer_name }}</p>
                                    </div>
                                </div>
                                <div class="flex items-start space-x-3">
                                    <x-icon name="heroicon-o-envelope" class="h-5 w-5 text-gray-400 mt-1" />
                                    <div>
                                        <p class="text-sm text-gray-600">Email Address</p>
                                        <a href="mailto:{{ $order->customer_email }}"
                                            class="font-semibold text-amber-600 hover:text-amber-700">{{ $order->customer_email }}</a>
                                    </div>
                                </div>
                            </div>
                            <div class="space-y-4">
                                <div class="flex items-start space-x-3">
                                    <x-icon name="heroicon-o-phone" class="h-5 w-5 text-gray-400 mt-1" />
                                    <div>
                                        <p class="text-sm text-gray-600">Phone Number</p>
                                        <a href="tel:{{ $order->customer_phone }}"
                                            class="font-semibold text-amber-600 hover:text-amber-700">{{ $order->customer_phone }}</a>
                                    </div>
                                </div>
                                <div class="flex items-start space-x-3">
                                    <x-icon name="heroicon-o-map-pin" class="h-5 w-5 text-gray-400 mt-1" />
                                    <div>
                                        <p class="text-sm text-gray-600">Address</p>
                                        <p class="font-semibold text-gray-900">{{ $order->customer_address }}</p>
                                    </div>
                                </div>
                            </div>
                        </div>
                        @if ($order->notes)
                            <div class="mt-6 pt-6 border-t border-gray-200">
                                <div class="flex items-start space-x-3">
                                    <x-icon name="heroicon-o-chat-bubble-left-ellipsis"
                                        class="h-5 w-5 text-gray-400 mt-1" />
                                    <div>
                                        <p class="text-sm text-gray-600">Order Notes</p>
                                        <p class="font-semibold text-gray-900">{{ $order->notes }}</p>
                                    </div>
                                </div>
                            </div>
                        @endif
                    </div>
                </div>

                <!-- Sidebar -->
                <div class="space-y-8">
                    <!-- Order Summary -->
                    <div class="bg-white rounded-2xl shadow-lg border border-gray-100 overflow-hidden">
                        <div class="bg-gradient-to-r from-amber-500 to-orange-500 p-6 text-white">
                            <h2 class="text-xl font-bold flex items-center">
                                <x-icon name="heroicon-o-calculator" class="h-5 w-5 mr-2" />
                                Order Summary
                            </h2>
                        </div>
                        <div class="p-6">
                            <div class="space-y-4">
                                <div class="flex justify-between items-center">
                                    <span class="text-gray-600">Items
                                        ({{ $order->orderItems->sum('quantity') }})</span>
                                    <span
                                        class="font-semibold text-gray-900">{{ $order->formatted_total_amount }}</span>
                                </div>
                                <div class="flex justify-between items-center">
                                    <span class="text-gray-600">Pickup</span>
                                    <span class="font-semibold text-green-600">Free</span>
                                </div>
                                <div class="border-t border-gray-200 pt-4">
                                    <div class="flex justify-between items-center">
                                        <span class="text-xl font-bold text-gray-900">Total</span>
                                        <span
                                            class="text-2xl font-bold text-amber-600">{{ $order->formatted_total_amount }}</span>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>

                    <!-- Payment Information -->
                    @if ($order->payment)
                        <div class="bg-white rounded-2xl shadow-lg border border-gray-100 overflow-hidden">
                            <div class="bg-gradient-to-r from-blue-500 to-purple-500 p-6 text-white">
                                <h2 class="text-xl font-bold flex items-center">
                                    <x-icon name="heroicon-o-credit-card" class="h-5 w-5 mr-2" />
                                    Payment Details
                                </h2>
                            </div>
                            <div class="p-6">
                                <div class="space-y-4">
                                    <div class="flex justify-between items-center">
                                        <span class="text-gray-600">Method</span>
                                        <span
                                            class="font-semibold text-gray-900">{{ $order->payment->payment_method->label() }}</span>
                                    </div>
                                    <div class="flex justify-between items-center">
                                        <span class="text-gray-600">Status</span>
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
                                                    <x-icon name="heroicon-o-question-mark-circle" class="h-3 w-3 mr-1" />
                                            @endswitch
                                            {{ $order->payment->payment_status->label() }}
                                        </span>
                                    </div>
                                    <div class="flex justify-between items-center">
                                        <span class="text-gray-600">Amount</span>
                                        <span
                                            class="font-semibold text-gray-900">{{ $order->payment->formatted_amount }}</span>
                                    </div>
                                    @if ($order->payment->payment_proof)
                                        <div class="pt-4 border-t border-gray-200">
                                            <p class="text-sm text-gray-600 mb-2 flex items-center">
                                                <x-icon name="heroicon-o-photo" class="h-4 w-4 mr-1" />
                                                Payment Proof
                                            </p>
                                            <img src="{{ Storage::url($order->payment->payment_proof) }}"
                                                alt="Payment Proof" class="w-full rounded-lg border border-gray-200">
                                        </div>
                                    @endif
                                </div>
                            </div>
                        </div>
                    @endif

                    <!-- Order Actions -->
                    @php
                        // use App\Rules\StatusCanBeChanged;
                        // use App\Enums\OrderStatus;
                        $allowedTransitions = App\Rules\StatusCanBeChanged::getAllowedTransitions(
                            $order->status,
                            'order',
                        );
                        $canCancel = in_array(App\Enums\OrderStatus::CANCELLED->value, $allowedTransitions);
                    @endphp

                    @if ($canCancel)
                        <div class="bg-white rounded-2xl shadow-lg border border-gray-100 overflow-hidden">
                            <div class="bg-gradient-to-r from-red-500 to-red-600 p-6 text-white">
                                <h2 class="text-xl font-bold flex items-center">
                                    <x-icon name="heroicon-o-exclamation-triangle" class="h-5 w-5 mr-2" />
                                    Order Actions
                                </h2>
                            </div>
                            <div class="p-6">
                                <div class="space-y-4">
                                    <p class="text-sm text-gray-600">
                                        You can cancel this order if you no longer need it. If you've already paid, a
                                        refund will be processed within 3-5 business days.
                                    </p>
                                    <button onclick="openCancelModal()"
                                        class="w-full bg-red-600 hover:bg-red-700 text-white px-4 py-3 rounded-lg font-medium transition-colors flex items-center justify-center">
                                        <x-icon name="heroicon-o-x-circle" class="h-5 w-5 mr-2" />
                                        Cancel Order
                                    </button>
                                </div>
                            </div>
                        </div>
                    @endif

                    <!-- Store Information -->
                    <div class="bg-white rounded-2xl shadow-lg border border-gray-100 overflow-hidden">
                        <div class="bg-gradient-to-r from-green-500 to-teal-500 p-6 text-white">
                            <h2 class="text-xl font-bold flex items-center">
                                <x-icon name="heroicon-o-building-storefront" class="h-5 w-5 mr-2" />
                                Pickup Information
                            </h2>
                        </div>
                        <div class="p-6">
                            <div class="space-y-4">
                                <div class="flex items-start space-x-3">
                                    <x-icon name="heroicon-o-map-pin" class="h-5 w-5 text-gray-400 mt-1" />
                                    <div>
                                        <p class="text-sm text-gray-600">Store Address</p>
                                        <p class="font-semibold text-gray-900">Jl. Sudirman No. 123<br>Palembang, South
                                            Sumatra 30126</p>
                                    </div>
                                </div>
                                <div class="flex items-start space-x-3">
                                    <x-icon name="heroicon-o-clock" class="h-5 w-5 text-gray-400 mt-1" />
                                    <div>
                                        <p class="text-sm text-gray-600">Store Hours</p>
                                        <div class="font-semibold text-gray-900">
                                            <p>Mon - Sat: 9:00 AM - 6:00 PM</p>
                                            <p>Sunday: 10:00 AM - 4:00 PM</p>
                                        </div>
                                    </div>
                                </div>
                                <div class="flex items-start space-x-3">
                                    <x-icon name="heroicon-o-phone" class="h-5 w-5 text-gray-400 mt-1" />
                                    <div>
                                        <p class="text-sm text-gray-600">Contact</p>
                                        <a href="tel:+62711123456"
                                            class="font-semibold text-green-600 hover:text-green-700">+62 711 123
                                            456</a>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <!-- Cancel Order Modal -->
    @if ($canCancel)
        <div id="cancelModal"
            class="fixed inset-0 bg-black bg-opacity-50 hidden z-50 flex items-center justify-center p-4">
            <div class="bg-white rounded-2xl shadow-2xl max-w-md w-full mx-4">
                <div class="p-6">
                    <div class="flex items-center mb-4">
                        <div class="w-12 h-12 bg-red-100 rounded-full flex items-center justify-center mr-4">
                            <x-icon name="heroicon-o-exclamation-triangle" class="h-6 w-6 text-red-600" />
                        </div>
                        <div>
                            <h3 class="text-lg font-bold text-gray-900">Cancel Order</h3>
                            <p class="text-sm text-gray-600">Order #{{ $order->order_number }}</p>
                        </div>
                    </div>

                    <div class="mb-6">
                        <p class="text-gray-700 mb-4">
                            Are you sure you want to cancel this order? This action cannot be undone.
                        </p>
                        @if ($order->payment && $order->payment->payment_status->value === 'paid')
                            <div class="bg-yellow-50 border border-yellow-200 rounded-lg p-4">
                                <div class="flex items-start">
                                    <x-icon name="heroicon-o-information-circle"
                                        class="h-5 w-5 text-yellow-600 mr-2 mt-0.5" />
                                    <div>
                                        <p class="text-sm text-yellow-800 font-medium">Refund Information</p>
                                        <p class="text-sm text-yellow-700 mt-1">
                                            Since you've already paid for this order, a refund will be processed within
                                            3-5 business days.
                                        </p>
                                    </div>
                                </div>
                            </div>
                        @endif
                    </div>

                    <div class="flex space-x-3">
                        <button onclick="closeCancelModal()"
                            class="flex-1 bg-gray-200 hover:bg-gray-300 text-gray-800 px-4 py-2 rounded-lg font-medium transition-colors">
                            Keep Order
                        </button>
                        <form method="POST" action="{{ route('orders.cancel', $order) }}" class="flex-1">
                            @csrf
                            <input type="hidden" name="status" value="canceled">
                            <button type="submit"
                                class="w-full bg-red-600 hover:bg-red-700 text-white px-4 py-2 rounded-lg font-medium transition-colors">
                                Yes, Cancel Order
                            </button>
                        </form>
                    </div>
                </div>
            </div>
        </div>

        <script>
            function openCancelModal() {
                document.getElementById('cancelModal').classList.remove('hidden');
                document.body.style.overflow = 'hidden';
            }

            function closeCancelModal() {
                document.getElementById('cancelModal').classList.add('hidden');
                document.body.style.overflow = 'auto';
            }

            // Close modal when clicking outside
            document.getElementById('cancelModal').addEventListener('click', function(e) {
                if (e.target === this) {
                    closeCancelModal();
                }
            });

            // Close modal with Escape key
            document.addEventListener('keydown', function(e) {
                if (e.key === 'Escape') {
                    closeCancelModal();
                }
            });
        </script>
    @endif
</x-app-layout>
