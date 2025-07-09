<x-app-layout>
    <x-slot name="title">Checkout - Palembang Songket Store</x-slot>

    <div class="min-h-screen bg-gradient-to-br from-amber-50 via-orange-50 to-yellow-50">
        <!-- Progress Bar -->
        <div class="bg-white shadow-sm border-b border-gray-200">
            <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8 py-4">
                <div class="flex items-center justify-center space-x-8">
                    <div class="flex items-center">
                        <div
                            class="w-8 h-8 bg-amber-500 text-white rounded-full flex items-center justify-center text-sm font-bold">
                            1</div>
                        <span class="ml-2 text-sm font-medium text-amber-600">Customer Info</span>
                    </div>
                    <div class="w-16 h-0.5 bg-gray-300"></div>
                    <div class="flex items-center">
                        <div
                            class="w-8 h-8 bg-gray-300 text-gray-600 rounded-full flex items-center justify-center text-sm font-bold">
                            2</div>
                        <span class="ml-2 text-sm font-medium text-gray-500">Payment</span>
                    </div>
                    <div class="w-16 h-0.5 bg-gray-300"></div>
                    <div class="flex items-center">
                        <div
                            class="w-8 h-8 bg-gray-300 text-gray-600 rounded-full flex items-center justify-center text-sm font-bold">
                            3</div>
                        <span class="ml-2 text-sm font-medium text-gray-500">Confirmation</span>
                    </div>
                </div>
            </div>
        </div>

        <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8 py-8">
            <div class="mb-8">
                <h1 class="text-3xl md:text-4xl font-bold text-gray-900 font-serif mb-4">Checkout</h1>
                <p class="text-lg text-gray-600">Complete your order details to proceed with payment</p>
            </div>

            <form method="POST" action="{{ route('checkout.store') }}" class="grid grid-cols-1 lg:grid-cols-3 gap-8"
                x-data="checkoutForm()">
                @csrf

                <!-- Customer Information -->
                <div class="lg:col-span-2 space-y-6">
                    <!-- Customer Details Card -->
                    <div class="bg-white rounded-2xl shadow-sm border border-gray-100 p-8">
                        <div class="flex items-center mb-6">
                            <div class="w-10 h-10 bg-amber-100 rounded-full flex items-center justify-center mr-3">
                                <x-icon name="heroicon-o-user" class="h-5 w-5 text-amber-600" />
                            </div>
                            <h2 class="text-2xl font-bold text-gray-900">Customer Information</h2>
                        </div>

                        <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
                            <div>
                                <label for="customer_name" class="block text-sm font-semibold text-gray-700 mb-2">Full
                                    Name *</label>
                                <input type="text" id="customer_name" name="customer_name"
                                    value="{{ old('customer_name', auth()->user()->name) }}" required
                                    class="w-full px-4 py-3 border border-gray-300 rounded-xl focus:ring-2 focus:ring-amber-500 focus:border-transparent transition-all duration-200"
                                    placeholder="Enter your full name">
                                @error('customer_name')
                                    <p class="mt-2 text-sm text-red-600 flex items-center">
                                        <x-icon name="heroicon-o-exclamation-circle" class="h-4 w-4 mr-1" />
                                        {{ $message }}
                                    </p>
                                @enderror
                            </div>

                            <div>
                                <label for="customer_email" class="block text-sm font-semibold text-gray-700 mb-2">Email
                                    Address *</label>
                                <input type="email" id="customer_email" name="customer_email"
                                    value="{{ old('customer_email', auth()->user()->email) }}" required
                                    class="w-full px-4 py-3 border border-gray-300 rounded-xl focus:ring-2 focus:ring-amber-500 focus:border-transparent transition-all duration-200"
                                    placeholder="Enter your email address">
                                @error('customer_email')
                                    <p class="mt-2 text-sm text-red-600 flex items-center">
                                        <x-icon name="heroicon-o-exclamation-circle" class="h-4 w-4 mr-1" />
                                        {{ $message }}
                                    </p>
                                @enderror
                            </div>

                            <div>
                                <label for="customer_phone" class="block text-sm font-semibold text-gray-700 mb-2">Phone
                                    Number *</label>
                                <input type="tel" id="customer_phone" name="customer_phone"
                                    value="{{ old('customer_phone') }}" required
                                    class="w-full px-4 py-3 border border-gray-300 rounded-xl focus:ring-2 focus:ring-amber-500 focus:border-transparent transition-all duration-200"
                                    placeholder="e.g., +62 812 3456 7890">
                                @error('customer_phone')
                                    <p class="mt-2 text-sm text-red-600 flex items-center">
                                        <x-icon name="heroicon-o-exclamation-circle" class="h-4 w-4 mr-1" />
                                        {{ $message }}
                                    </p>
                                @enderror
                            </div>

                            <div class="md:col-span-2">
                                <label for="customer_address"
                                    class="block text-sm font-semibold text-gray-700 mb-2">Address *</label>
                                <textarea id="customer_address" name="customer_address" rows="4" required
                                    class="w-full px-4 py-3 border border-gray-300 rounded-xl focus:ring-2 focus:ring-amber-500 focus:border-transparent transition-all duration-200"
                                    placeholder="Enter your address for pickup coordination and contact purposes">{{ old('customer_address') }}</textarea>
                                @error('customer_address')
                                    <p class="mt-2 text-sm text-red-600 flex items-center">
                                        <x-icon name="heroicon-o-exclamation-circle" class="h-4 w-4 mr-1" />
                                        {{ $message }}
                                    </p>
                                @enderror
                            </div>

                            <div class="md:col-span-2">
                                <label for="notes" class="block text-sm font-semibold text-gray-700 mb-2">Order Notes
                                    (Optional)</label>
                                <textarea id="notes" name="notes" rows="3"
                                    class="w-full px-4 py-3 border border-gray-300 rounded-xl focus:ring-2 focus:ring-amber-500 focus:border-transparent transition-all duration-200"
                                    placeholder="Any special instructions, preferred pickup time, or other requests...">{{ old('notes') }}</textarea>
                                @error('notes')
                                    <p class="mt-2 text-sm text-red-600 flex items-center">
                                        <x-icon name="heroicon-o-exclamation-circle" class="h-4 w-4 mr-1" />
                                        {{ $message }}
                                    </p>
                                @enderror
                            </div>
                        </div>
                    </div>


                    <!-- Order Items Review -->
                    <div class="bg-white rounded-2xl shadow-sm border border-gray-100 p-8">
                        <div class="flex items-center mb-6">
                            <div class="w-10 h-10 bg-amber-100 rounded-full flex items-center justify-center mr-3">
                                <x-icon name="heroicon-o-shopping-bag" class="h-5 w-5 text-amber-600" />
                            </div>
                            <h2 class="text-2xl font-bold text-gray-900">Order Review</h2>
                        </div>

                        <div class="space-y-6">
                            @foreach ($cartItems as $item)
                                <div class="flex items-center space-x-4 py-4 border-b border-gray-200 last:border-b-0">
                                    <div
                                        class="w-20 h-20 bg-gradient-to-br from-amber-100 to-orange-100 rounded-xl overflow-hidden shadow-sm">
                                        <img src="{{ $item->songket->primary_image }}"
                                            alt="{{ $item->songket->name }}" class="w-full h-full object-cover">
                                    </div>

                                    <div class="flex-1">
                                        <h3 class="font-semibold text-gray-900 mb-1">{{ $item->songket->name }}</h3>
                                        <p class="text-sm text-gray-600 mb-2">{{ $item->songket->category->name }}</p>

                                        @if ($item->selected_color)
                                            <div class="flex items-center space-x-4 text-xs text-gray-500">
                                                <div class="flex items-center space-x-1">
                                                    <span>Color:</span>
                                                    <div class="w-3 h-3 rounded-full border border-gray-300"
                                                        style="background-color: {{ $item->selected_color }}">
                                                    </div>
                                                    <span>{{ ucfirst($item->selected_color) }}</span>
                                                </div>
                                            </div>
                                        @endif
                                    </div>

                                    <div class="text-right">
                                        <div class="font-bold text-gray-900">{{ $item->formatted_total_price }}</div>
                                        <div class="text-sm text-gray-500">Qty: {{ $item->quantity }}</div>
                                    </div>
                                </div>
                            @endforeach
                        </div>
                    </div>
                </div>

                <!-- Order Summary Sidebar -->
                <div class="lg:col-span-1">
                    <div class="sticky top-8">
                        <div class="bg-white rounded-2xl shadow-lg border border-gray-100 overflow-hidden">
                            <!-- Header -->
                            <div class="bg-gradient-to-r from-amber-500 to-orange-500 p-6 text-white">
                                <h2 class="text-xl font-bold flex items-center">
                                    <x-icon name="heroicon-o-document-text" class="h-5 w-5 mr-2" />
                                    Order Summary
                                </h2>
                            </div>

                            <!-- Content -->
                            <div class="p-6">
                                <div class="space-y-4 mb-6">
                                    <div class="flex justify-between items-center">
                                        <span class="text-gray-600">Subtotal ({{ $cartItems->sum('quantity') }}
                                            items)</span>
                                        <span class="font-semibold text-gray-900">Rp
                                            {{ number_format($total, 0, ',', '.') }}</span>
                                    </div>
                                    <div class="flex justify-between items-center">
                                        <span class="text-gray-600">Tax</span>
                                        <span class="font-semibold text-gray-900">Included</span>
                                    </div>
                                    <div class="border-t border-gray-200 pt-4">
                                        <div class="flex justify-between items-center">
                                            <span class="text-xl font-bold text-gray-900">Total</span>
                                            <span class="text-2xl font-bold text-amber-600">Rp
                                                {{ number_format($total, 0, ',', '.') }}</span>
                                        </div>
                                    </div>
                                </div>

                                <button type="submit" :disabled="submitting"
                                    class="w-full bg-gradient-to-r from-amber-500 to-orange-500 hover:from-amber-600 hover:to-orange-600 disabled:from-gray-400 disabled:to-gray-500 text-white py-4 rounded-xl font-bold text-lg transition-all duration-300 shadow-lg hover:shadow-xl transform hover:-translate-y-0.5 disabled:transform-none disabled:cursor-not-allowed">
                                    <div class="flex items-center justify-center">
                                        <div x-show="submitting" class="animate-spin -ml-1 mr-3 h-5 w-5 text-white">
                                            <svg class="h-5 w-5" xmlns="http://www.w3.org/2000/svg" fill="none"
                                                viewBox="0 0 24 24">
                                                <circle class="opacity-25" cx="12" cy="12" r="10"
                                                    stroke="currentColor" stroke-width="4"></circle>
                                                <path class="opacity-75" fill="currentColor"
                                                    d="M4 12a8 8 0 018-8V0C5.373 0 0 5.373 0 12h4zm2 5.291A7.962 7.962 0 014 12H0c0 3.042 1.135 5.824 3 7.938l3-2.647z">
                                                </path>
                                            </svg>
                                        </div>
                                        <x-icon name="heroicon-o-arrow-right" class="h-5 w-5 mr-2"
                                            x-show="!submitting" />
                                        <span x-text="submitting ? 'Processing...' : 'Continue to Payment'"></span>
                                    </div>
                                </button>

                                <!-- Security Notice -->
                                <div class="mt-6 pt-6 border-t border-gray-200">
                                    <div class="flex items-center text-sm text-gray-600">
                                        <x-icon name="heroicon-o-shield-check" class="h-4 w-4 text-green-500 mr-2" />
                                        <span>Your information is secure and encrypted</span>
                                    </div>
                                </div>
                            </div>
                        </div>

                        <!-- Help Section -->
                        <div class="mt-6 bg-blue-50 rounded-2xl p-6 border border-blue-200">
                            <div class="flex items-center mb-3">
                                <x-icon name="heroicon-o-question-mark-circle" class="h-5 w-5 text-blue-600 mr-2" />
                                <h3 class="font-semibold text-blue-900">Need Help?</h3>
                            </div>
                            <p class="text-sm text-blue-700 mb-4">
                                Our customer service team is here to assist you with your order.
                            </p>
                            <div class="space-y-2 text-sm text-blue-600">
                                <div class="flex items-center">
                                    <x-icon name="heroicon-o-phone" class="h-4 w-4 mr-2" />
                                    <span>+62 711 123456</span>
                                </div>
                                <div class="flex items-center">
                                    <x-icon name="heroicon-o-envelope" class="h-4 w-4 mr-2" />
                                    <span>support@songketpalembang.com</span>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </form>
        </div>
    </div>

    <script>
        function checkoutForm() {
            return {
                submitting: false,

                init() {
                    // Form validation and enhancement can be added here
                    this.$el.addEventListener('submit', (e) => {
                        this.submitting = true;
                    });
                }
            }
        }
    </script>
</x-app-layout>
