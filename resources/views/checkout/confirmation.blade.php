<x-app-layout>
    <x-slot name="title">Order Confirmation - Order #{{ $order->order_number }}</x-slot>

    <div class="min-h-screen bg-gradient-to-br from-amber-50 via-orange-50 to-yellow-50">
        <!-- Progress Bar -->
        <div class="bg-white shadow-sm border-b border-gray-200">
            <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8 py-4">
                <div class="flex items-center justify-center space-x-8">
                    <div class="flex items-center">
                        <div
                            class="w-8 h-8 bg-green-500 text-white rounded-full flex items-center justify-center text-sm font-bold">
                            <x-icon name="heroicon-o-check" class="h-4 w-4" />
                        </div>
                        <span class="ml-2 text-sm font-medium text-green-600">Customer Info</span>
                    </div>
                    <div class="w-16 h-0.5 bg-green-500"></div>
                    <div class="flex items-center">
                        <div
                            class="w-8 h-8 bg-green-500 text-white rounded-full flex items-center justify-center text-sm font-bold">
                            <x-icon name="heroicon-o-check" class="h-4 w-4" />
                        </div>
                        <span class="ml-2 text-sm font-medium text-green-600">Payment</span>
                    </div>
                    <div class="w-16 h-0.5 bg-green-500"></div>
                    <div class="flex items-center">
                        <div
                            class="w-8 h-8 bg-green-500 text-white rounded-full flex items-center justify-center text-sm font-bold">
                            <x-icon name="heroicon-o-check" class="h-4 w-4" />
                        </div>
                        <span class="ml-2 text-sm font-medium text-green-600">Confirmation</span>
                    </div>
                </div>
            </div>
        </div>

        <div class="max-w-4xl mx-auto px-4 sm:px-6 lg:px-8 py-8">
            <!-- Success Message -->
            <div class="text-center mb-8">
                <div class="w-20 h-20 bg-green-100 rounded-full flex items-center justify-center mx-auto mb-4">
                    <x-icon name="heroicon-o-check-circle" class="h-12 w-12 text-green-600" />
                </div>
                <h1 class="text-3xl md:text-4xl font-bold text-gray-900 font-serif mb-4">Order Confirmed!</h1>
                <p class="text-lg text-gray-600">Thank you for your order. We'll process it shortly.</p>
            </div>

            <!-- Order Details Card -->
            <div class="bg-white rounded-2xl shadow-lg border border-gray-100 overflow-hidden mb-8">
                <!-- Header -->
                <div class="bg-gradient-to-r from-amber-500 to-orange-500 p-6 text-white">
                    <div class="flex items-center justify-between">
                        <div>
                            <h2 class="text-2xl font-bold">Order #{{ $order->order_number }}</h2>
                            <p class="text-amber-100">{{ $order->created_at->format('F j, Y \a\t g:i A') }}</p>
                        </div>
                        <div class="text-right">
                            <div
                                class="inline-flex items-center px-3 py-1 rounded-full text-sm font-medium bg-white/20 text-white">
                                <x-icon name="heroicon-o-clock" class="h-4 w-4 mr-1" />
                                {{ $order->status->label() }}
                            </div>
                        </div>
                    </div>
                </div>

                <!-- Content -->
                <div class="p-6">
                    <div class="grid grid-cols-1 lg:grid-cols-2 gap-8">
                        <!-- Order Items -->
                        <div>
                            <h3 class="text-xl font-bold text-gray-900 mb-4 flex items-center">
                                <x-icon name="heroicon-o-shopping-bag" class="h-5 w-5 mr-2 text-amber-600" />
                                Order Items
                            </h3>
                            <div class="space-y-4">
                                @foreach ($order->orderItems as $item)
                                    <div class="flex items-center space-x-4 p-4 bg-gray-50 rounded-xl">
                                        <div class="w-16 h-16 bg-amber-100 rounded-lg flex items-center justify-center">
                                            <x-icon name="heroicon-o-sparkles" class="h-8 w-8 text-amber-600" />
                                        </div>
                                        <div class="flex-1">
                                            <h4 class="font-semibold text-gray-900">{{ $item->songket->name }}</h4>
                                            <p class="text-sm text-gray-600">{{ $item->songket->category->name }}</p>
                                            <div class="flex items-center space-x-4 text-sm text-gray-500 mt-1">
                                                @if ($item->selected_color)
                                                    <span class="flex items-center">
                                                        <x-icon name="heroicon-o-swatch" class="h-3 w-3 mr-1" />
                                                        {{ $item->selected_color }}
                                                    </span>
                                                @endif
                                                <span class="flex items-center">
                                                    <x-icon name="heroicon-o-hashtag" class="h-3 w-3 mr-1" />
                                                    Qty: {{ $item->quantity }}
                                                </span>
                                            </div>
                                        </div>
                                        <div class="text-right">
                                            <p class="font-semibold text-gray-900">{{ $item->formatted_total_price }}
                                            </p>
                                        </div>
                                    </div>
                                @endforeach
                            </div>
                        </div>

                        <!-- Order Summary -->
                        <div>
                            <h3 class="text-xl font-bold text-gray-900 mb-4 flex items-center">
                                <x-icon name="heroicon-o-calculator" class="h-5 w-5 mr-2 text-amber-600" />
                                Order Summary
                            </h3>
                            <div class="bg-gray-50 rounded-xl p-6 space-y-4">
                                <div class="flex justify-between items-center">
                                    <span class="text-gray-600">Subtotal</span>
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

                            <!-- Payment Information -->
                            @if ($order->payment)
                                <div class="mt-6">
                                    <h4 class="font-semibold text-gray-900 mb-3 flex items-center">
                                        <x-icon name="heroicon-o-credit-card" class="h-4 w-4 mr-2 text-amber-600" />
                                        Payment Information
                                    </h4>
                                    <div class="bg-white border border-gray-200 rounded-lg p-4 space-y-2">
                                        <div class="flex justify-between text-sm">
                                            <span class="text-gray-600">Method:</span>
                                            <span
                                                class="font-medium text-gray-900">{{ $order->payment->payment_method->label() }}</span>
                                        </div>
                                        <div class="flex justify-between text-sm">
                                            <span class="text-gray-600">Status:</span>
                                            <span
                                                class="inline-flex items-center px-2 py-1 rounded-full text-xs font-medium {{ $order->payment->payment_status->color() === 'green' ? 'bg-green-100 text-green-800' : ($order->payment->payment_status->color() === 'yellow' ? 'bg-yellow-100 text-yellow-800' : 'bg-red-100 text-red-800') }}">
                                                {{ $order->payment->payment_status->label() }}
                                            </span>
                                        </div>
                                        @if ($order->payment->payment_proof)
                                            <div class="pt-2">
                                                <span class="text-sm text-gray-600 flex items-center">
                                                    <x-icon name="heroicon-o-document-check" class="h-4 w-4 mr-1" />
                                                    Payment proof uploaded
                                                </span>
                                            </div>
                                        @endif
                                    </div>
                                </div>
                            @endif
                        </div>
                    </div>
                </div>
            </div>

            <!-- Customer Information -->
            <div class="bg-white rounded-2xl shadow-lg border border-gray-100 overflow-hidden mb-8">
                <div class="p-6">
                    <h3 class="text-xl font-bold text-gray-900 mb-6 flex items-center">
                        <x-icon name="heroicon-o-user" class="h-5 w-5 mr-2 text-amber-600" />
                        Customer Information
                    </h3>
                    <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
                        <div class="space-y-4">
                            <div class="flex items-start space-x-3">
                                <x-icon name="heroicon-o-user-circle" class="h-5 w-5 text-gray-400 mt-0.5" />
                                <div>
                                    <p class="text-sm text-gray-600">Name</p>
                                    <p class="font-semibold text-gray-900">{{ $order->customer_name }}</p>
                                </div>
                            </div>
                            <div class="flex items-start space-x-3">
                                <x-icon name="heroicon-o-envelope" class="h-5 w-5 text-gray-400 mt-0.5" />
                                <div>
                                    <p class="text-sm text-gray-600">Email</p>
                                    <a href="mailto:{{ $order->customer_email }}"
                                        class="font-semibold text-amber-600 hover:text-amber-700">{{ $order->customer_email }}</a>
                                </div>
                            </div>
                        </div>
                        <div class="space-y-4">
                            <div class="flex items-start space-x-3">
                                <x-icon name="heroicon-o-phone" class="h-5 w-5 text-gray-400 mt-0.5" />
                                <div>
                                    <p class="text-sm text-gray-600">Phone</p>
                                    <a href="tel:{{ $order->customer_phone }}"
                                        class="font-semibold text-amber-600 hover:text-amber-700">{{ $order->customer_phone }}</a>
                                </div>
                            </div>
                            <div class="flex items-start space-x-3">
                                <x-icon name="heroicon-o-map-pin" class="h-5 w-5 text-gray-400 mt-0.5" />
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
                                    class="h-5 w-5 text-gray-400 mt-0.5" />
                                <div>
                                    <p class="text-sm text-gray-600">Notes</p>
                                    <p class="font-semibold text-gray-900">{{ $order->notes }}</p>
                                </div>
                            </div>
                        </div>
                    @endif
                </div>
            </div>

            <!-- Next Steps -->
            <div class="bg-blue-50 rounded-2xl p-6 border border-blue-200 mb-8">
                <h3 class="text-xl font-bold text-blue-900 mb-4 flex items-center">
                    <x-icon name="heroicon-o-information-circle" class="h-5 w-5 mr-2" />
                    What's Next?
                </h3>
                <div class="space-y-3 text-blue-800">
                    @if ($order->payment && $order->payment->payment_method->value === 'pay_in_store')
                        <div class="flex items-start space-x-3">
                            <x-icon name="heroicon-o-building-storefront" class="h-5 w-5 text-blue-600 mt-0.5" />
                            <p>Visit our store to complete payment and pick up your order</p>
                        </div>
                    @else
                        <div class="flex items-start space-x-3">
                            <x-icon name="heroicon-o-clock" class="h-5 w-5 text-blue-600 mt-0.5" />
                            <p>We'll verify your payment within 1-2 business hours</p>
                        </div>
                        <div class="flex items-start space-x-3">
                            <x-icon name="heroicon-o-envelope" class="h-5 w-5 text-blue-600 mt-0.5" />
                            <p>You'll receive an email confirmation once payment is verified</p>
                        </div>
                    @endif
                    <div class="flex items-start space-x-3">
                        <x-icon name="heroicon-o-phone" class="h-5 w-5 text-blue-600 mt-0.5" />
                        <p>We'll contact you when your order is ready for pickup</p>
                    </div>
                </div>
            </div>

            <!-- Store Information -->
            <div class="bg-white rounded-2xl shadow-lg border border-gray-100 overflow-hidden">
                <div class="p-6">
                    <h3 class="text-xl font-bold text-gray-900 mb-6 flex items-center">
                        <x-icon name="heroicon-o-building-storefront" class="h-5 w-5 mr-2 text-amber-600" />
                        Store Information
                    </h3>
                    <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
                        <div class="space-y-4">
                            <div class="flex items-start space-x-3">
                                <x-icon name="heroicon-o-map-pin" class="h-5 w-5 text-gray-400 mt-0.5" />
                                <div>
                                    <p class="text-sm text-gray-600">Address</p>
                                    <p class="font-semibold text-gray-900">Jl. Sudirman No. 123<br>Palembang, South
                                        Sumatra 30126</p>
                                </div>
                            </div>
                            <div class="flex items-start space-x-3">
                                <x-icon name="heroicon-o-phone" class="h-5 w-5 text-gray-400 mt-0.5" />
                                <div>
                                    <p class="text-sm text-gray-600">Phone</p>
                                    <a href="tel:+62711123456"
                                        class="font-semibold text-amber-600 hover:text-amber-700">+62 711 123 456</a>
                                </div>
                            </div>
                        </div>
                        <div class="space-y-4">
                            <div class="flex items-start space-x-3">
                                <x-icon name="heroicon-o-clock" class="h-5 w-5 text-gray-400 mt-0.5" />
                                <div>
                                    <p class="text-sm text-gray-600">Store Hours</p>
                                    <div class="font-semibold text-gray-900">
                                        <p>Mon - Sat: 9:00 AM - 6:00 PM</p>
                                        <p>Sunday: 10:00 AM - 4:00 PM</p>
                                    </div>
                                </div>
                            </div>
                            <div class="flex items-start space-x-3">
                                <x-icon name="heroicon-o-envelope" class="h-5 w-5 text-gray-400 mt-0.5" />
                                <div>
                                    <p class="text-sm text-gray-600">Email</p>
                                    <a href="mailto:info@palembangsongket.com"
                                        class="font-semibold text-amber-600 hover:text-amber-700">info@palembangsongket.com</a>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>

            <!-- Action Buttons -->
            <div class="flex flex-col sm:flex-row gap-4 mt-8">
                <a href="{{ route('orders.index') }}"
                    class="flex-1 bg-gradient-to-r from-amber-500 to-orange-500 hover:from-amber-600 hover:to-orange-600 text-white py-4 px-6 rounded-xl font-bold text-center transition-all duration-300 shadow-lg hover:shadow-xl transform hover:-translate-y-0.5">
                    <x-icon name="heroicon-o-list-bullet" class="h-5 w-5 inline mr-2" />
                    View All Orders
                </a>
                <a href="{{ route('catalog.index') }}"
                    class="flex-1 bg-white hover:bg-gray-50 text-gray-900 py-4 px-6 rounded-xl font-bold text-center transition-all duration-300 shadow-lg hover:shadow-xl transform hover:-translate-y-0.5 border border-gray-200">
                    <x-icon name="heroicon-o-shopping-bag" class="h-5 w-5 inline mr-2" />
                    Continue Shopping
                </a>
            </div>
        </div>
    </div>
</x-app-layout>
