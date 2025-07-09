<x-app-layout>
    <x-slot name="title">{{ $songket->name }} - Palembang Songket Store</x-slot>

    <div class="bg-gradient-to-br from-amber-50 to-orange-50 py-8">
        <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
            <!-- Breadcrumb -->
            <nav class="flex mb-8" aria-label="Breadcrumb">
                <ol class="inline-flex items-center space-x-1 md:space-x-3">
                    <li class="inline-flex items-center">
                        <a href="{{ route('home') }}" class="text-gray-700 hover:text-amber-600">Home</a>
                    </li>
                    <li>
                        <div class="flex items-center">
                            <svg class="w-6 h-6 text-gray-400" fill="currentColor" viewBox="0 0 20 20">
                                <path fill-rule="evenodd"
                                    d="M7.293 14.707a1 1 0 010-1.414L10.586 10 7.293 6.707a1 1 0 011.414-1.414l4 4a1 1 0 010 1.414l-4 4a1 1 0 01-1.414 0z"
                                    clip-rule="evenodd"></path>
                            </svg>
                            <a href="{{ route('catalog.index') }}"
                                class="ml-1 text-gray-700 hover:text-amber-600 md:ml-2">Catalog</a>
                        </div>
                    </li>
                    <li>
                        <div class="flex items-center">
                            <svg class="w-6 h-6 text-gray-400" fill="currentColor" viewBox="0 0 20 20">
                                <path fill-rule="evenodd"
                                    d="M7.293 14.707a1 1 0 010-1.414L10.586 10 7.293 6.707a1 1 0 011.414-1.414l4 4a1 1 0 010 1.414l-4 4a1 1 0 01-1.414 0z"
                                    clip-rule="evenodd"></path>
                            </svg>
                            <span class="ml-1 text-gray-500 md:ml-2">{{ $songket->name }}</span>
                        </div>
                    </li>
                </ol>
            </nav>

            <div class="grid grid-cols-1 lg:grid-cols-2 gap-12">
                <!-- Product Images -->
                <div class="space-y-4" x-data="{ activeImage: 0 }">
                    <!-- Main Image -->
                    <div class="aspect-square bg-white rounded-lg shadow-lg overflow-hidden">
                        @if ($songket->images && count($songket->images) > 0)
                            @foreach ($songket->images as $index => $image)
                                <img x-show="activeImage === {{ $index }}" src="{{ $image }}"
                                    alt="{{ $songket->name }}" class="w-full h-full object-cover">
                            @endforeach
                        @else
                            <img src="/placeholder.svg?height=600&width=600" alt="{{ $songket->name }}"
                                class="w-full h-full object-cover">
                        @endif
                    </div>

                    <!-- Thumbnail Images -->
                    @if ($songket->images && count($songket->images) > 1)
                        <div class="flex space-x-2 p-3 overflow-x-auto">
                            @foreach ($songket->images as $index => $image)
                                <button @click="activeImage = {{ $index }}"
                                    :class="{ 'ring-2 ring-amber-500': activeImage === {{ $index }} }"
                                    class="flex-shrink-0 w-20 h-20 bg-white rounded-lg overflow-hidden shadow-sm hover:shadow-md transition-shadow">
                                    <img src="{{ $image }}" alt="{{ $songket->name }}"
                                        class="w-full h-full object-cover">
                                </button>
                            @endforeach
                        </div>
                    @endif
                </div>

                <!-- Product Info -->
                <div class="space-y-6" x-data="productDetail()">
                    <div>
                        <p class="text-amber-600 font-medium mb-2">{{ $songket->category->name }}</p>
                        <h1 class="text-3xl md:text-4xl font-bold text-gray-900 font-serif mb-4">{{ $songket->name }}
                        </h1>
                        <div class="text-3xl font-bold text-amber-600 mb-4" x-text="formatPrice(currentPrice)"></div>

                        @if ($songket->reviews_count > 0)
                            <div class="flex items-center mb-4">
                                <div class="flex items-center">
                                    @for ($i = 1; $i <= 5; $i++)
                                        <svg class="w-5 h-5 {{ $i <= round($songket->reviews_avg_rating) ? 'text-yellow-400' : 'text-gray-300' }}"
                                            fill="currentColor" viewBox="0 0 20 20">
                                            <path
                                                d="M9.049 2.927c.3-.921 1.603-.921 1.902 0l1.07 3.292a1 1 0 00.95.69h3.462c.969 0 1.371 1.24.588 1.81l-2.8 2.034a1 1 0 00-.364 1.118l1.07 3.292c.3.921-.755 1.688-1.54 1.118l-2.8-2.034a1 1 0 00-1.175 0l-2.8 2.034c-.784.57-1.838-.197-1.539-1.118l1.07-3.292a1 1 0 00-.364-1.118L2.98 8.72c-.783-.57-.38-1.81.588-1.81h3.461a1 1 0 00.951-.69l1.07-3.292z">
                                            </path>
                                        </svg>
                                    @endfor
                                </div>
                                <span class="ml-2 text-gray-600">{{ number_format($songket->reviews_avg_rating, 1) }}
                                    ({{ $songket->reviews_count }} reviews)</span>
                            </div>
                        @endif
                    </div>

                    <div class="prose prose-gray max-w-none">
                        <p>{{ $songket->description }}</p>
                    </div>

                    <!-- Color Selection -->
                    @if ($songket->colors && count($songket->colors) > 0)
                        <div>
                            <h3 class="text-lg font-semibold text-gray-900 mb-3">Available Colors</h3>
                            <div class="flex flex-wrap gap-3">
                                @foreach ($songket->colors as $color)
                                    <button @click="selectedColor = '{{ $color }}'"
                                        :class="{ 'ring-2 ring-amber-500 ring-offset-2': selectedColor === '{{ $color }}' }"
                                        class="w-12 h-12 rounded-full border-2 border-gray-200 hover:scale-105 transition-transform"
                                        style="background-color: {{ $color }}" title="{{ ucfirst($color) }}">
                                    </button>
                                @endforeach
                            </div>
                            <p class="text-sm text-gray-600 mt-2">Selected: <span x-text="selectedColor || 'None'"
                                    class="font-medium"></span></p>
                        </div>
                    @endif


                    <!-- Quantity -->
                    <div>
                        <h3 class="text-lg font-semibold text-gray-900 mb-3">Quantity</h3>
                        <div class="flex items-center space-x-3">
                            <button @click="quantity = Math.max(1, quantity - 1)"
                                class="w-10 h-10 rounded-full bg-gray-100 hover:bg-gray-200 flex items-center justify-center transition-colors">
                                <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M20 12H4">
                                    </path>
                                </svg>
                            </button>
                            <span class="text-xl font-semibold w-12 text-center" x-text="quantity"></span>
                            <button @click="quantity = Math.min(10, quantity + 1)"
                                class="w-10 h-10 rounded-full bg-gray-100 hover:bg-gray-200 flex items-center justify-center transition-colors">
                                <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                        d="M12 6v6m0 0v6m0-6h6m-6 0H6"></path>
                                </svg>
                            </button>
                        </div>
                    </div>

                    <!-- Add to Cart -->
                    @auth
                        <div class="space-y-4">
                            <button @click="addToCart()" :disabled="!canAddToCart()"
                                :class="{ 'opacity-50 cursor-not-allowed': !canAddToCart() }"
                                class="w-full bg-amber-500 hover:bg-amber-600 text-white py-4 rounded-lg font-semibold text-lg transition-colors">
                                Add to Cart - <span x-text="formatPrice(currentPrice * quantity)"></span>
                            </button>

                            <div x-show="!canAddToCart()" class="text-red-600 text-sm">
                                <p x-show="!selectedColor && {{ count($songket->colors ?? []) }} > 0">Please select a
                                    color</p>
                            </div>
                        </div>
                    @else
                        <div class="space-y-4">
                            <a href="{{ route('login') }}"
                                class="block w-full bg-amber-500 hover:bg-amber-600 text-white py-4 rounded-lg font-semibold text-lg text-center transition-colors">
                                Login to Purchase
                            </a>
                        </div>
                    @endauth

                    <!-- Product Details -->
                    <div class="border-t border-gray-200 pt-6">
                        <h3 class="text-lg font-semibold text-gray-900 mb-4">Product Details</h3>
                        <dl class="space-y-2">
                            <div class="flex">
                                <dt class="text-gray-600 w-24">Category:</dt>
                                <dd class="text-gray-900">{{ $songket->category->name }}</dd>
                            </div>
                            <div class="flex">
                                <dt class="text-gray-600 w-24">Stock:</dt>
                                <dd class="text-gray-900">{{ $songket->stock_quantity }} available</dd>
                            </div>
                            @if ($songket->colors)
                                <div class="flex">
                                    <dt class="text-gray-600 w-24">Colors:</dt>
                                    <dd class="text-gray-900">{{ count($songket->colors) }} options</dd>
                                </div>
                            @endif

                        </dl>
                    </div>
                    <!-- Success Modal -->
                    <x-modal name="cart-success" :show="false" max-width="md">
                        <div class="p-6">
                            <div
                                class="flex items-center justify-center w-12 h-12 mx-auto bg-green-100 rounded-full mb-4">
                                <x-icon name="heroicon-o-check-circle" class="w-6 h-6 text-green-600" />
                            </div>

                            <div class="text-center">
                                <h3 class="text-lg font-medium text-gray-900 mb-2">Added to Cart!</h3>
                                <p class="text-sm text-gray-600 mb-6">Product has been successfully added to your cart.
                                </p>

                                <div class="flex flex-col sm:flex-row gap-3 justify-center">
                                    <button @click="$dispatch('close-modal', 'cart-success')"
                                        class="px-4 py-2 bg-gray-100 hover:bg-gray-200 text-gray-800 rounded-lg font-medium transition-colors">
                                        Continue Shopping
                                    </button>
                                    <a href="{{ route('cart.index') }}"
                                        class="px-4 py-2 bg-amber-500 hover:bg-amber-600 text-white rounded-lg font-medium transition-colors">
                                        View Cart
                                    </a>
                                </div>
                            </div>
                        </div>
                    </x-modal>
                    <!-- Error Modal -->
                    <x-modal name="cart-error" :show="false" max-width="md">
                        <div class="p-6">
                            <div
                                class="flex items-center justify-center w-12 h-12 mx-auto bg-red-100 rounded-full mb-4">
                                <x-icon name="heroicon-o-x-circle" class="w-6 h-6 text-red-600" />
                            </div>

                            <div class="text-center">
                                <h3 class="text-lg font-medium text-gray-900 mb-2">Error</h3>
                                <p class="text-sm text-gray-600 mb-6" x-text="errorMessage">There was an error adding
                                    the product to
                                    your cart.</p>

                                <div class="flex justify-center">
                                    <button @click="$dispatch('close-modal', 'cart-error')"
                                        class="px-4 py-2 bg-red-500 hover:bg-red-600 text-white rounded-lg font-medium transition-colors">
                                        Close
                                    </button>
                                </div>
                            </div>
                        </div>
                    </x-modal>
                </div>
            </div>

            <!-- Related Products -->
            @if ($relatedSongkets->count() > 0)
                <div class="mt-16">
                    <h2 class="text-2xl md:text-3xl font-bold text-gray-900 font-serif mb-8">Related Products</h2>
                    <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-4 gap-6">
                        @foreach ($relatedSongkets as $related)
                            <x-product-card :songket="$related" />
                        @endforeach
                    </div>
                </div>
            @endif

            <!-- Reviews Section -->
            @if ($songket->reviews->count() > 0)
                <div class="mt-16">
                    <h2 class="text-2xl md:text-3xl font-bold text-gray-900 font-serif mb-8">Customer Reviews</h2>
                    <div class="space-y-6">
                        @foreach ($songket->reviews->take(5) as $review)
                            <div class="bg-white rounded-lg p-6 shadow-sm">
                                <div class="flex items-center mb-4">
                                    <img src="https://ui-avatars.com/api/?name={{ urlencode($review->user->name) }}&color=7c3aed&background=fbbf24"
                                        alt="{{ $review->user->name }}" class="w-10 h-10 rounded-full">
                                    <div class="ml-3">
                                        <p class="font-medium text-gray-900">{{ $review->user->name }}</p>
                                        <div class="flex items-center">
                                            @for ($i = 1; $i <= 5; $i++)
                                                <svg class="w-4 h-4 {{ $i <= $review->rating ? 'text-yellow-400' : 'text-gray-300' }}"
                                                    fill="currentColor" viewBox="0 0 20 20">
                                                    <path
                                                        d="M9.049 2.927c.3-.921 1.603-.921 1.902 0l1.07 3.292a1 1 0 00.95.69h3.462c.969 0 1.371 1.24.588 1.81l-2.8 2.034a1 1 0 00-.364 1.118l1.07 3.292c.3.921-.755 1.688-1.54 1.118l-2.8-2.034a1 1 0 00-1.175 0l-2.8 2.034c-.784.57-1.838-.197-1.539-1.118l1.07-3.292a1 1 0 00-.364-1.118L2.98 8.72c-.783-.57-.38-1.81.588-1.81h3.461a1 1 0 00.951-.69l1.07-3.292z">
                                                    </path>
                                                </svg>
                                            @endfor
                                            <span
                                                class="ml-2 text-sm text-gray-600">{{ $review->created_at->format('M d, Y') }}</span>
                                        </div>
                                    </div>
                                </div>
                                <p class="text-gray-700">{{ $review->comment }}</p>
                            </div>
                        @endforeach
                    </div>
                </div>
            @endif
        </div>
    </div>





    <script>
        function productDetail() {
            return {
                selectedColor: @json($songket->colors[0] ?? null),
                quantity: 1,
                basePrice: {{ $songket->base_price }},
                errorMessage: '',

                get currentPrice() {
                    return this.basePrice;
                },

                canAddToCart() {
                    const needsColor = {{ count($songket->colors ?? []) }} > 0;
                    const quantityValid = this.quantity > 0 && this.quantity <= {{ $songket->stock_quantity }};

                    return (!needsColor || this.selectedColor) &&
                        quantityValid;
                },

                formatPrice(price) {
                    return 'Rp ' + new Intl.NumberFormat('id-ID').format(price);
                },

                async addToCart() {
                    if (!this.canAddToCart()) return


                    try {
                        const response = await fetch('{{ route('cart.add') }}', {
                            method: 'POST',
                            headers: {
                                'Content-Type': 'application/json',
                                'Accept': 'application/json',
                                'X-CSRF-TOKEN': document.querySelector('meta[name="csrf-token"]').content
                            },
                            body: JSON.stringify({
                                songket_id: {{ $songket->id }},
                                quantity: this.quantity,
                                selected_color: this.selectedColor,
                                price: this.currentPrice
                            })
                        });

                        const data = await response.json();

                        if (data.success) {
                            // Show success modal
                            this.$dispatch('open-modal', 'cart-success');

                            // Optionally reload to update cart count after a delay
                            setTimeout(() => {
                                window.location.reload();
                            }, 2000);
                        } else {
                            this.errorMessage = data.message || 'Error adding product to cart';
                            this.$dispatch('open-modal', 'cart-error');
                        }
                    } catch (error) {
                        console.error('Error:', error);
                        this.errorMessage = 'Network error. Please try again.';
                        this.$dispatch('open-modal', 'cart-error');
                    }
                }
            }
        }
    </script>
</x-app-layout>
