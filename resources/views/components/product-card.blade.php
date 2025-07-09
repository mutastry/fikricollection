@props(['songket'])

<div
    class="group relative bg-white rounded-xl shadow-sm border border-gray-100 overflow-hidden hover:shadow-lg hover:border-amber-200 transition-all duration-300">
    <div class="aspect-square overflow-hidden bg-gradient-to-br from-amber-100 to-orange-100">
        <img src="{{ $songket->primary_image }}" alt="{{ $songket->name }}"
            class="w-full h-full object-cover group-hover:scale-105 transition-transform duration-300">

        @if ($songket->is_featured)
            <div
                class="absolute top-3 left-3 bg-amber-500 text-white px-3 py-1 rounded-full text-xs font-semibold flex items-center">
                <x-icon name="heroicon-o-star" class="h-3 w-3 mr-1" />
                Featured
            </div>
        @endif

        @if ($songket->stock_quantity <= 5 && $songket->stock_quantity > 0)
            <div
                class="absolute top-3 right-3 bg-orange-500 text-white px-3 py-1 rounded-full text-xs font-semibold flex items-center">
                <x-icon name="heroicon-o-exclamation-triangle" class="h-3 w-3 mr-1" />
                Low Stock
            </div>
        @elseif($songket->stock_quantity === 0)
            <div
                class="absolute top-3 right-3 bg-red-500 text-white px-3 py-1 rounded-full text-xs font-semibold flex items-center">
                <x-icon name="heroicon-o-x-circle" class="h-3 w-3 mr-1" />
                Out of Stock
            </div>
        @endif
    </div>

    <div class="p-6">
        <div class="mb-3">
            <span class="inline-flex items-center text-sm text-amber-600 font-medium bg-amber-50 px-2 py-1 rounded-md">
                <x-icon name="heroicon-o-tag" class="h-3 w-3 mr-1" />
                {{ $songket->category->name }}
            </span>
        </div>

        <h3 class="text-lg font-semibold text-gray-900 mb-2 group-hover:text-amber-600 transition-colors line-clamp-2">
            {{ $songket->name }}
        </h3>

        <p class="text-gray-600 text-sm mb-4 line-clamp-2">
            {{ Str::limit($songket->description, 100) }}
        </p>

        <div class="flex items-center justify-between mb-4">
            <div class="text-2xl font-bold text-amber-600">
                {{ $songket->formatted_price }}
            </div>

            @if ($songket->reviews_count > 0)
                <div class="flex items-center text-sm text-gray-500">
                    <x-icon name="heroicon-o-star" class="h-4 w-4 text-yellow-400 mr-1" />
                    <span>{{ number_format($songket->reviews_avg_rating, 1) }} ({{ $songket->reviews_count }})</span>
                </div>
            @endif
        </div>

        <!-- Colors Preview -->
        @if ($songket->colors && count($songket->colors) > 0)
            <div class="flex items-center gap-2 mb-4">
                <span class="text-xs text-gray-500 flex items-center">
                    <x-icon name="heroicon-o-swatch" class="h-3 w-3 mr-1" />
                    Colors:
                </span>
                <div class="flex gap-1">
                    @foreach (array_slice($songket->colors, 0, 4) as $color)
                        <div class="w-4 h-4 rounded-full border border-gray-200 shadow-sm"
                            style="background-color: {{ $color }}"></div>
                    @endforeach
                    @if (count($songket->colors) > 4)
                        <div
                            class="w-4 h-4 rounded-full border border-gray-200 bg-gray-100 flex items-center justify-center">
                            <span class="text-xs text-gray-600 font-medium">+{{ count($songket->colors) - 4 }}</span>
                        </div>
                    @endif
                </div>
            </div>
        @endif

        <!-- Stock Info -->
        <div class="flex items-center justify-between mb-4 text-xs text-gray-500">
            <span class="flex items-center">
                <x-icon name="heroicon-o-cube" class="h-3 w-3 mr-1" />
                {{ $songket->stock_quantity }} in stock
            </span>
        </div>

        <a href="{{ route('catalog.show', $songket) }}"
            class=" w-full bg-amber-500 hover:bg-amber-600 text-white text-center py-3 rounded-lg font-semibold transition-colors group-hover:bg-amber-600 flex items-center justify-center">
            <x-icon name="heroicon-o-eye" class="h-4 w-4 mr-2" />
            View Details
        </a>
    </div>
</div>
