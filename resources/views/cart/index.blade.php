<x-app-layout>
    <x-slot name="title">Shopping Cart - Palembang Songket Store</x-slot>

    <div class="min-h-screen bg-gradient-to-br from-amber-50 via-orange-50 to-yellow-50">
        <!-- Header Section -->
        <div class="bg-white shadow-sm border-b border-gray-200">
            <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8 py-6">
                <div class="flex items-center justify-between">
                    <div>
                        <h1 class="text-2xl md:text-3xl font-bold text-gray-900 font-serif">Shopping Cart</h1>
                        <p class="text-gray-600 mt-1">Review and manage your selected items</p>
                    </div>
                    <div class="hidden sm:flex items-center space-x-4">
                        <div class="flex items-center text-sm text-gray-500">
                            <x-icon name="heroicon-o-shield-check" class="h-4 w-4 mr-1" />
                            <span>Secure Checkout</span>
                        </div>
                    </div>
                </div>
            </div>
        </div>

        <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8 py-8">
            <x-session-alerts />
            @if ($cartItems->count() > 0)
                <div class="grid grid-cols-2 xl:grid-cols-4 gap-8" x-data="cartManager()">
                    <!-- Cart Items Section -->
                    <div class="xl:col-span-3">
                        <!-- Cart Header -->
                        <div class="bg-white rounded-2xl shadow-sm border border-gray-100 p-6 mb-6">
                            <div class="flex flex-col sm:flex-row sm:items-center sm:justify-between gap-4">
                                <div class="flex items-center space-x-3">
                                    <div class="w-10 h-10 bg-amber-100 rounded-full flex items-center justify-center">
                                        <x-icon name="heroicon-o-shopping-bag" class="h-5 w-5 text-amber-600" />
                                    </div>
                                    <div>
                                        <h2 class="text-lg font-semibold text-gray-900">Your Items</h2>
                                        <p class="text-sm text-gray-600">{{ $cartItems->count() }} items in your
                                            cart</p>
                                    </div>
                                </div>
                                <button @click="confirmClearCart()"
                                    class="inline-flex items-center px-4 py-2 text-red-600 hover:text-red-800 hover:bg-red-50 rounded-xl font-medium transition-all duration-200 border border-red-200 hover:border-red-300">
                                    <x-icon name="heroicon-o-trash" class="h-4 w-4 mr-2" />
                                    Clear All
                                </button>
                            </div>
                        </div>

                        <!-- Cart Items -->
                        <div class="space-y-4">
                            @foreach ($cartItems as $item)
                                <div class="bg-white rounded-2xl shadow-sm border border-gray-100 hover:shadow-md transition-all duration-300"
                                    x-data="cartItem({{ $item->id }}, {{ $item->quantity }}, {{ $item->price }})">
                                    <div class="p-6">
                                        <div class="flex flex-col lg:flex-row gap-6">
                                            <!-- Product Image -->
                                            <div class="flex-shrink-0">
                                                <div class="relative group">
                                                    <div
                                                        class="w-32 h-32 lg:w-28 lg:h-28 bg-gradient-to-br from-amber-100 to-orange-100 rounded-2xl overflow-hidden shadow-sm">
                                                        <img src="{{ $item->songket->primary_image }}"
                                                            alt="{{ $item->songket->name }}"
                                                            class="w-full h-full object-cover group-hover:scale-110 transition-transform duration-500">
                                                    </div>
                                                    <div
                                                        class="absolute -top-2 -right-2 w-6 h-6 bg-amber-500 text-white rounded-full flex items-center justify-center text-xs font-bold">
                                                        <span x-text="quantity"></span>
                                                    </div>
                                                </div>
                                            </div>

                                            <!-- Product Details -->
                                            <div class="flex-1 min-w-0">
                                                <div class="flex flex-col lg:flex-row lg:justify-between gap-4">
                                                    <!-- Product Info -->
                                                    <div class="flex-1">
                                                        <h3
                                                            class="text-xl font-semibold text-gray-900 mb-2 line-clamp-2">
                                                            <a href="{{ route('catalog.show', $item->songket) }}"
                                                                class="hover:text-amber-600 transition-colors">
                                                                {{ $item->songket->name }}
                                                            </a>
                                                        </h3>

                                                        <div class="flex items-center text-sm text-gray-600 mb-3">
                                                            <x-icon name="heroicon-o-tag" class="h-4 w-4 mr-1" />
                                                            <span
                                                                class="bg-gray-100 px-2 py-1 rounded-lg">{{ $item->songket->category->name }}</span>
                                                        </div>

                                                        @if ($item->selected_color)
                                                            <div class="flex flex-wrap items-center gap-3 mb-4">
                                                                <div
                                                                    class="flex items-center space-x-2 bg-gray-50 px-3 py-2 rounded-lg">
                                                                    <span class="text-sm text-gray-600">Color:</span>
                                                                    <div class="w-4 h-4 rounded-full border-2 border-white shadow-sm ring-1 ring-gray-300"
                                                                        style="background-color: {{ $item->selected_color }}">
                                                                    </div>
                                                                    <span
                                                                        class="text-sm text-gray-900 font-medium">{{ ucfirst($item->selected_color) }}</span>
                                                                </div>
                                                            </div>
                                                        @endif

                                                        <!-- Quantity Controls -->
                                                        <div class="flex items-center space-x-4">
                                                            <span
                                                                class="text-sm font-medium text-gray-700">Quantity:</span>
                                                            <div
                                                                class="flex items-center bg-gray-50 rounded-xl border border-gray-200">
                                                                <button @click="updateQuantity(quantity - 1)"
                                                                    :disabled="quantity <= 1 || updating"
                                                                    :class="{
                                                                        'opacity-50 cursor-not-allowed': quantity <=
                                                                            1 ||
                                                                            updating
                                                                    }"
                                                                    class="w-10 h-10 flex items-center justify-center text-gray-600 hover:text-amber-600 hover:bg-amber-50 transition-all duration-200 rounded-l-xl">
                                                                    <x-icon name="heroicon-o-minus" class="w-4 h-4" />
                                                                </button>
                                                                <div class="w-16 h-10 flex items-center justify-center text-sm font-bold bg-white border-x border-gray-200"
                                                                    x-text="quantity"></div>
                                                                <button @click="updateQuantity(quantity + 1)"
                                                                    :disabled="quantity >= 10 || updating"
                                                                    :class="{
                                                                        'opacity-50 cursor-not-allowed': quantity >=
                                                                            10 ||
                                                                            updating
                                                                    }"
                                                                    class="w-10 h-10 flex items-center justify-center text-gray-600 hover:text-amber-600 hover:bg-amber-50 transition-all duration-200 rounded-r-xl">
                                                                    <x-icon name="heroicon-o-plus" class="w-4 h-4" />
                                                                </button>
                                                            </div>
                                                            <div x-show="updating"
                                                                class="flex items-center text-sm text-amber-600">
                                                                <svg class="animate-spin -ml-1 mr-2 h-4 w-4"
                                                                    xmlns="http://www.w3.org/2000/svg" fill="none"
                                                                    viewBox="0 0 24 24">
                                                                    <circle class="opacity-25" cx="12"
                                                                        cy="12" r="10" stroke="currentColor"
                                                                        stroke-width="4"></circle>
                                                                    <path class="opacity-75" fill="currentColor"
                                                                        d="M4 12a8 8 0 018-8V0C5.373 0 0 5.373 0 12h4zm2 5.291A7.962 7.962 0 014 12H0c0 3.042 1.135 5.824 3 7.938l3-2.647z">
                                                                    </path>
                                                                </svg>
                                                                Updating...
                                                            </div>
                                                        </div>
                                                    </div>

                                                    <!-- Price and Actions -->
                                                    <div
                                                        class="flex flex-col items-end justify-between lg:min-w-[200px]">
                                                        <div class="text-right mb-4">
                                                            <div class="text-2xl font-bold text-amber-600 mb-1"
                                                                x-text="formatPrice(totalPrice)"></div>
                                                            <div class="text-sm text-gray-500"
                                                                x-text="formatPrice(unitPrice) + ' each'"></div>
                                                        </div>

                                                        <button
                                                            @click="confirmRemove({{ $item->id }}, '{{ $item->songket->name }}')"
                                                            class="inline-flex items-center px-4 py-2 text-red-600 hover:text-red-800 hover:bg-red-50 rounded-xl font-medium transition-all duration-200 border border-red-200 hover:border-red-300">
                                                            <x-icon name="heroicon-o-trash" class="w-4 h-4 mr-2" />
                                                            Remove
                                                        </button>
                                                    </div>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            @endforeach
                        </div>
                    </div>

                    <!-- Order Summary Sidebar -->
                    <div class="xl:col-span-1">
                        <div class="sticky top-8">
                            <!-- Order Summary Card -->
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
                                        <div class="flex justify-between items-center py-2">
                                            <span class="text-gray-600">Subtotal ({{ $cartItems->sum('quantity') }}
                                                items)</span>
                                            <span class="font-semibold text-gray-900">Rp
                                                {{ number_format($total, 0, ',', '.') }}</span>
                                        </div>
                                        <div class="border-t border-gray-200 pt-4">
                                            <div class="flex justify-between items-center">
                                                <span class="text-xl font-bold text-gray-900">Total</span>
                                                <span class="text-2xl font-bold text-amber-600">Rp
                                                    {{ number_format($total, 0, ',', '.') }}</span>
                                            </div>
                                        </div>
                                    </div>

                                    <!-- Action Buttons -->
                                    <div>
                                        {{-- <a href="{{ route('home') }}" --}}
                                        <a href="{{ route('checkout.index') }}"
                                            class="block w-full bg-gradient-to-r from-amber-500 to-orange-500 hover:from-amber-600 hover:to-orange-600 text-white text-center py-4 rounded-xl font-bold text-lg transition-all duration-300 shadow-lg hover:shadow-xl transform hover:-translate-y-0.5 mb-3">
                                            <div class="flex items-center justify-center">
                                                <x-icon name="heroicon-o-credit-card" class="h-5 w-5 mr-2" />
                                                Proceed to Checkout
                                            </div>
                                        </a>
                                        <a href="{{ route('catalog.index') }}"
                                            class="block w-full bg-gray-100 hover:bg-gray-200 text-gray-800 text-center py-3 rounded-xl font-semibold transition-all duration-200 border border-gray-300">
                                            <div class="flex items-center justify-center">
                                                <x-icon name="heroicon-o-arrow-left" class="h-4 w-4 mr-2" />
                                                Continue Shopping
                                            </div>
                                        </a>
                                    </div>
                                </div>

                                <!-- Trust Badges -->
                                <div class="bg-gray-50 p-6 border-t border-gray-200">
                                    <h3 class="text-sm font-bold text-gray-900 mb-4 flex items-center">
                                        <x-icon name="heroicon-o-shield-check" class="h-4 w-4 mr-2" />
                                        Why Choose Us?
                                    </h3>
                                    <div class="space-y-3 text-sm text-gray-600">
                                        <div class="flex items-center">
                                            <x-icon name="heroicon-o-check-circle"
                                                class="h-4 w-4 text-green-500 mr-3 flex-shrink-0" />
                                            <span>100% Authentic Songket</span>
                                        </div>
                                        <div class="flex items-center">
                                            <x-icon name="heroicon-o-check-circle"
                                                class="h-4 w-4 text-green-500 mr-3 flex-shrink-0" />
                                            <span>Master Artisan Crafted</span>
                                        </div>

                                        <div class="flex items-center">
                                            <x-icon name="heroicon-o-check-circle"
                                                class="h-4 w-4 text-green-500 mr-3 flex-shrink-0" />
                                            <span>Quality Guarantee</span>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>

                    <!-- Modals -->
                    <x-modal name="remove-item" :show="false" max-width="md">
                        <div class="p-8">
                            <div
                                class="flex items-center justify-center w-16 h-16 mx-auto bg-red-100 rounded-full mb-6">
                                <x-icon name="heroicon-o-exclamation-triangle" class="w-8 h-8 text-red-600" />
                            </div>

                            <div class="text-center">
                                <h3 class="text-xl font-bold text-gray-900 mb-3">Remove Item</h3>
                                <p class="text-gray-600 mb-8">
                                    Are you sure you want to remove "<span class="font-semibold"
                                        x-text="itemToRemove.name"></span>" from your cart?
                                </p>

                                <div class="flex flex-col sm:flex-row gap-3 justify-center">
                                    <button @click="$dispatch('close-modal', 'remove-item')"
                                        class="px-6 py-3 bg-gray-100 hover:bg-gray-200 text-gray-800 rounded-xl font-semibold transition-colors">
                                        Cancel
                                    </button>
                                    <button @click="removeItem()"
                                        class="px-6 py-3 bg-red-500 hover:bg-red-600 text-white rounded-xl font-semibold transition-colors">
                                        Remove Item
                                    </button>
                                </div>
                            </div>
                        </div>
                    </x-modal>

                    <x-modal name="clear-cart" :show="false" max-width="md">
                        <div class="p-8">
                            <div
                                class="flex items-center justify-center w-16 h-16 mx-auto bg-red-100 rounded-full mb-6">
                                <x-icon name="heroicon-o-exclamation-triangle" class="w-8 h-8 text-red-600" />
                            </div>

                            <div class="text-center">
                                <h3 class="text-xl font-bold text-gray-900 mb-3">Clear Cart</h3>
                                <p class="text-gray-600 mb-8">
                                    Are you sure you want to remove all items from your cart? This action cannot be
                                    undone.
                                </p>

                                <div class="flex flex-col sm:flex-row gap-3 justify-center">
                                    <button @click="$dispatch('close-modal', 'clear-cart')"
                                        class="px-6 py-3 bg-gray-100 hover:bg-gray-200 text-gray-800 rounded-xl font-semibold transition-colors">
                                        Cancel
                                    </button>
                                    <button @click="clearCart()"
                                        class="px-6 py-3 bg-red-500 hover:bg-red-600 text-white rounded-xl font-semibold transition-colors">
                                        Clear Cart
                                    </button>
                                </div>
                            </div>
                        </div>
                    </x-modal>

                    <x-modal name="cart-success" :show="false" max-width="md">
                        <div class="p-8">
                            <div
                                class="flex items-center justify-center w-16 h-16 mx-auto bg-green-100 rounded-full mb-6">
                                <x-icon name="heroicon-o-check-circle" class="w-8 h-8 text-green-600" />
                            </div>

                            <div class="text-center">
                                <h3 class="text-xl font-bold text-gray-900 mb-3">Success!</h3>
                                <p class="text-gray-600 mb-8" x-text="successMessage"></p>

                                <div class="flex justify-center">
                                    <x-primary-button @click="$dispatch('close-modal', 'cart-success')">
                                        Continue
                                    </x-primary-button>
                                </div>
                            </div>
                        </div>
                    </x-modal>

                    <x-modal name="cart-error" :show="false" max-width="md">
                        <div class="p-8">
                            <div
                                class="flex items-center justify-center w-16 h-16 mx-auto bg-red-100 rounded-full mb-6">
                                <x-icon name="heroicon-o-x-circle" class="w-8 h-8 text-red-600" />
                            </div>

                            <div class="text-center">
                                <h3 class="text-xl font-bold text-gray-900 mb-3">Error</h3>
                                <p class="text-gray-600 mb-8" x-text="errorMessage"></p>

                                <div class="flex justify-center">
                                    <button @click="$dispatch('close-modal', 'cart-error')"
                                        class="px-6 py-3 bg-red-500 hover:bg-red-600 text-white rounded-xl font-semibold transition-colors">
                                        Close
                                    </button>
                                </div>
                            </div>
                        </div>
                    </x-modal>
                </div>
            @else
                <!-- Empty Cart State -->
                <div class="text-center py-20">
                    <div class="rounded-full flex items-center justify-center mb-8 ">
                        <x-icon name="heroicon-o-shopping-cart" class="h-20 w-20 text-amber-500" />
                    </div>
                    <h3 class="text-3xl font-bold text-gray-900 mb-4">Your cart is empty</h3>
                    <p class="text-lg text-gray-600 mb-10 max-w-md mx-auto">
                        Discover our exquisite collection of authentic Palembang Songket and start building your perfect
                        wardrobe
                    </p>
                    <div class="flex flex-col mt-4 sm:flex-row gap-4 justify-center">
                        <a href="{{ route('catalog.index') }}"
                            class="inline-flex items-center px-8 py-4 bg-gradient-to-r from-amber-500 to-orange-500 hover:from-amber-600 hover:to-orange-600 text-white rounded-xl font-bold text-lg transition-all duration-300 shadow-lg hover:shadow-xl transform hover:-translate-y-0.5">
                            <x-icon name="heroicon-o-squares-2x2" class="h-5 w-5 mr-2" />
                            Explore Collection
                        </a>
                        <a href="{{ route('home') }}"
                            class="inline-flex items-center px-8 py-4 bg-white hover:bg-gray-50 text-gray-800 rounded-xl font-semibold text-lg transition-all duration-200 border-2 border-gray-300 hover:border-gray-400 shadow-sm">
                            <x-icon name="heroicon-o-home" class="h-5 w-5 mr-2" />
                            Back to Home
                        </a>
                    </div>
                </div>
            @endif
        </div>
    </div>

    <script>
        function cartManager() {
            return {
                itemToRemove: {
                    id: null,
                    name: ''
                },
                successMessage: '',
                errorMessage: '',

                confirmRemove(itemId, itemName) {
                    this.itemToRemove = {
                        id: itemId,
                        name: itemName
                    };
                    this.$dispatch('open-modal', 'remove-item');
                },

                async removeItem() {
                    try {
                        const response = await fetch(`/cart/${this.itemToRemove.id}`, {
                            method: 'DELETE',
                            headers: {
                                'X-CSRF-TOKEN': document.querySelector('meta[name="csrf-token"]').content
                            }
                        });

                        if (response.ok) {
                            this.successMessage = 'Item removed from cart successfully!';
                            this.$dispatch('close-modal', 'remove-item');
                            this.$dispatch('open-modal', 'cart-success');
                            setTimeout(() => window.location.reload(), 1500);
                        } else {
                            throw new Error('Failed to remove item');
                        }
                    } catch (error) {
                        this.errorMessage = 'Failed to remove item. Please try again.';
                        this.$dispatch('close-modal', 'remove-item');
                        this.$dispatch('open-modal', 'cart-error');
                    }
                },

                confirmClearCart() {
                    this.$dispatch('open-modal', 'clear-cart');
                },

                async clearCart() {
                    try {
                        const response = await fetch('/cart', {
                            method: 'DELETE',
                            headers: {
                                'Content-Type': 'application/json',
                                'Accept': 'application/json',
                                'X-CSRF-TOKEN': document.querySelector('meta[name="csrf-token"]').content
                            }
                        });

                        if (response.ok) {
                            this.successMessage = 'Cart cleared successfully!';
                            this.$dispatch('close-modal', 'clear-cart');
                            this.$dispatch('open-modal', 'cart-success');
                            setTimeout(() => window.location.reload(), 1500);
                        } else {
                            throw new Error('Failed to clear cart');
                        }
                    } catch (error) {
                        this.errorMessage = 'Failed to clear cart. Please try again.';
                        this.$dispatch('close-modal', 'clear-cart');
                        this.$dispatch('open-modal', 'cart-error');
                    }
                }
            }
        }

        function cartItem(itemId, initialQuantity, unitPrice) {
            return {
                quantity: initialQuantity,
                unitPrice: unitPrice,
                updating: false,

                get totalPrice() {
                    return this.quantity * this.unitPrice;
                },

                formatPrice(price) {
                    return 'Rp ' + new Intl.NumberFormat('id-ID').format(price);
                },

                async updateQuantity(newQuantity) {
                    if (newQuantity < 1 || newQuantity > 10 || this.updating) return;

                    this.updating = true;

                    try {
                        const response = await fetch(`/cart/${itemId}`, {
                            method: 'PATCH',
                            headers: {
                                'Content-Type': 'application/json',
                                'Accept': 'application/json',
                                'X-CSRF-TOKEN': document.querySelector('meta[name="csrf-token"]').content
                            },
                            body: JSON.stringify({
                                quantity: newQuantity
                            })
                        });

                        const data = await response.json();
                        console.log('Update response:', data);

                        if (data.success) {
                            this.quantity = newQuantity;
                        } else {
                            throw new Error(data.message || 'Failed to update quantity');
                        }
                    } catch (error) {
                        console.error('Error updating cart:', error);
                    } finally {
                        this.updating = false;
                    }
                }
            }
        }
    </script>
</x-app-layout>
