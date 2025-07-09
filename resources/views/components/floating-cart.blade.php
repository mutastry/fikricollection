@php
    $cartItems = auth()->user()->cartItems()->with('songket')->get();
    $cartCount = $cartItems->count();
    $cartTotal = $cartItems->sum('total_price');
@endphp

@if ($cartCount > 0)
    <div class="fixed bottom-6 right-6 z-50" x-data="floatingCart()">
        <!-- Floating Cart Button -->
        <button @click="toggleCart()"
            class="bg-amber-500 hover:bg-amber-600 text-white rounded-full p-4 shadow-lg hover:shadow-xl transition-all duration-300 relative group">
            <x-icon name="heroicon-o-shopping-cart" class="w-6 h-6" />
            <span
                class="absolute -top-2 -right-2 bg-red-500 text-white text-xs rounded-full h-6 w-6 flex items-center justify-center font-semibold animate-pulse">
                {{ $cartCount }}
            </span>
            <!-- Tooltip -->
            <div
                class="absolute right-full mr-3 top-1/2 transform -translate-y-1/2 bg-gray-900 text-white text-sm px-3 py-2 rounded-lg opacity-0 group-hover:opacity-100 transition-opacity whitespace-nowrap">
                View Cart ({{ $cartCount }} items)
                <div
                    class="absolute left-full top-1/2 transform -translate-y-1/2 border-4 border-transparent border-l-gray-900">
                </div>
            </div>
        </button>

        <!-- Floating Cart Panel -->
        <div x-show="open" x-transition:enter="transition ease-out duration-300"
            x-transition:enter-start="opacity-0 transform scale-95 translate-y-4"
            x-transition:enter-end="opacity-100 transform scale-100 translate-y-0"
            x-transition:leave="transition ease-in duration-200"
            x-transition:leave-start="opacity-100 transform scale-100 translate-y-0"
            x-transition:leave-end="opacity-0 transform scale-95 translate-y-4" @click.away="open = false"
            class="absolute bottom-20 right-0 w-96 bg-white rounded-xl shadow-2xl border border-gray-200 max-h-[32rem] overflow-hidden"
            style="display: none;">

            <!-- Header -->
            <div class="p-4 border-b border-gray-200 bg-gradient-to-r from-amber-50 to-orange-50">
                <div class="flex items-center justify-between">
                    <h3 class="text-lg font-semibold text-gray-900 flex items-center">
                        <x-icon name="heroicon-o-shopping-cart" class="h-5 w-5 mr-2 text-amber-600" />
                        Shopping Cart
                    </h3>
                    <button @click="open = false" class="text-gray-400 hover:text-gray-600 transition-colors">
                        <x-icon name="heroicon-o-x-mark" class="h-5 w-5" />
                    </button>
                </div>
                <p class="text-sm text-gray-600 mt-1">{{ $cartCount }} items in your cart</p>
            </div>

            <!-- Cart Items -->
            <div class="max-h-80 overflow-y-auto">
                @foreach ($cartItems as $item)
                    <div class="p-4 border-b border-gray-100 hover:bg-gray-50 transition-colors">
                        <div class="flex items-center space-x-3">
                            <div class="flex-shrink-0">
                                <img src="{{ $item->songket->primary_image }}" alt="{{ $item->songket->name }}"
                                    class="w-12 h-12 object-cover rounded-lg shadow-sm">
                            </div>
                            <div class="flex-1 min-w-0">
                                <p class="text-sm font-medium text-gray-900 truncate">{{ $item->songket->name }}</p>
                                <div class="flex items-center text-xs text-gray-500 mt-1">
                                    @if ($item->selected_color)
                                        <span class="flex items-center mr-3">
                                            <div class="w-3 h-3 rounded-full border border-gray-300 mr-1"
                                                style="background-color: {{ $item->selected_color }}"></div>
                                            {{ ucfirst($item->selected_color) }}
                                        </span>
                                    @endif
                                </div>
                                <div class="flex items-center justify-between mt-2">
                                    <span class="text-xs text-gray-500">Qty: {{ $item->quantity }}</span>
                                    <span
                                        class="text-sm font-semibold text-amber-600">{{ $item->formatted_total_price }}</span>
                                </div>
                            </div>
                        </div>
                    </div>
                @endforeach
            </div>

            <!-- Footer -->
            <div class="p-4 border-t border-gray-200 bg-gray-50">
                <div class="flex justify-between items-center mb-4">
                    <span class="text-base font-semibold text-gray-900">Total:</span>
                    <span class="text-xl font-bold text-amber-600">Rp
                        {{ number_format($cartTotal, 0, ',', '.') }}</span>
                </div>
                <div class="space-y-2">
                    <a href="{{ route('cart.index') }}"
                        class="block w-full bg-gray-100 hover:bg-gray-200 text-gray-800 text-center py-2.5 rounded-lg font-medium transition-colors border border-gray-300">
                        <div class="flex items-center justify-center">
                            <x-icon name="heroicon-o-eye" class="h-4 w-4 mr-2" />
                            View Cart
                        </div>
                    </a>
                    <a href="{{ route('checkout.index') }}"
                        class="block w-full bg-amber-500 hover:bg-amber-600 text-white text-center py-2.5 rounded-lg font-semibold transition-colors shadow-sm hover:shadow-md">
                        <div class="flex items-center justify-center">
                            <x-icon name="heroicon-o-credit-card" class="h-4 w-4 mr-2" />
                            Checkout
                        </div>
                    </a>
                </div>
            </div>
        </div>
    </div>

    <script>
        function floatingCart() {
            return {
                open: false,

                toggleCart() {
                    this.open = !this.open;
                }
            }
        }
    </script>
@endif
