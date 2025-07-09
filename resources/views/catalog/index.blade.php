<x-app-layout>
    <x-slot name="title">Catalog - Palembang Songket Store</x-slot>

    <div class="bg-gradient-to-br from-amber-50 to-orange-50 py-8">
        <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
            <!-- Header -->
            <div class="mb-8">
                <h1 class="text-3xl md:text-4xl font-bold text-gray-900 font-serif mb-4">Songket Collection</h1>
                <p class="text-lg text-gray-600">Discover our exquisite collection of traditional Palembang Songket</p>
            </div>

            <!-- Filters -->
            <div class="bg-white rounded-xl shadow-sm border border-gray-100 p-6 mb-8">
                <div class="flex flex-col lg:flex-row lg:items-end lg:justify-between gap-6">
                    <!-- Search and Category Row -->
                    <div class="flex flex-col sm:flex-row gap-4 flex-1">
                        <!-- Search -->
                        <div class="flex-1">
                            <x-input-label for="search" value="Search Products" class="mb-2" />
                            <form method="GET" action="{{ route('catalog.index') }}" class="relative">
                                <div class="relative">
                                    <div class="absolute inset-y-0 left-0 pl-3 flex items-center pointer-events-none">
                                        <x-icon name="heroicon-o-magnifying-glass" class="h-5 w-5 text-gray-400" />
                                    </div>
                                    <x-text-input id="search" name="search" value="{{ request('search') }}"
                                        placeholder="Search songket by name or description..." class="pl-10 pr-4"
                                        onchange="this.form.submit()" />
                                </div>
                                @foreach (request()->except('search') as $key => $value)
                                    <input type="hidden" name="{{ $key }}" value="{{ $value }}">
                                @endforeach
                            </form>
                        </div>

                        <!-- Category Filter -->
                        <div class="min-w-64">
                            <x-input-label for="category" value="Category" class="mb-2" />
                            <form method="GET" action="{{ route('catalog.index') }}">
                                <div class="relative">
                                    <div class="absolute inset-y-0 left-0 pl-3 flex items-center pointer-events-none">
                                        <x-icon name="heroicon-o-tag" class="h-5 w-5 text-gray-400" />
                                    </div>
                                    <x-select-input id="category" name="category" onchange="this.form.submit()"
                                        class="pl-10 pr-8" placeholder="All Categories">
                                        @foreach ($categories as $category)
                                            <option value="{{ $category->slug }}"
                                                {{ request('category') === $category->slug ? 'selected' : '' }}>
                                                {{ $category->name }}
                                            </option>
                                        @endforeach
                                    </x-select-input>
                                </div>
                                @foreach (request()->except('category') as $key => $value)
                                    <input type="hidden" name="{{ $key }}" value="{{ $value }}">
                                @endforeach
                            </form>
                        </div>
                    </div>

                    <!-- Sort and Filter Actions -->
                    <div class="flex flex-col sm:flex-row gap-4 lg:min-w-80">
                        <!-- Sort -->
                        <div class="flex-1">
                            <x-input-label for="sort" value="Sort By" class="mb-2" />
                            <form method="GET" action="{{ route('catalog.index') }}">
                                <div class="relative">
                                    <div class="absolute inset-y-0 left-0 pl-3 flex items-center pointer-events-none">
                                        <x-icon name="heroicon-o-bars-arrow-down" class="h-5 w-5 text-gray-400" />
                                    </div>
                                    <x-select-input id="sort" name="sort" onchange="this.form.submit()"
                                        class="pl-10 pr-8">
                                        <option value="name" {{ request('sort') === 'name' ? 'selected' : '' }}>Name
                                            A-Z</option>
                                        <option value="name_desc"
                                            {{ request('sort') === 'name_desc' ? 'selected' : '' }}>Name Z-A</option>
                                        <option value="price" {{ request('sort') === 'price' ? 'selected' : '' }}>
                                            Price Low-High</option>
                                        <option value="price_desc"
                                            {{ request('sort') === 'price_desc' ? 'selected' : '' }}>Price High-Low
                                        </option>
                                        <option value="newest" {{ request('sort') === 'newest' ? 'selected' : '' }}>
                                            Newest First</option>
                                    </x-select-input>
                                </div>
                                @foreach (request()->except('sort') as $key => $value)
                                    <input type="hidden" name="{{ $key }}" value="{{ $value }}">
                                @endforeach
                            </form>
                        </div>

                        <!-- Clear Filters Button -->
                        @if (request()->hasAny(['search', 'category', 'sort']))
                            <div class="flex items-end">
                                <a href="{{ route('catalog.index') }}"
                                    class="inline-flex items-center px-4 py-2 bg-gray-100 hover:bg-gray-200 text-gray-700 rounded-lg font-medium transition-colors border border-gray-300">
                                    <x-icon name="heroicon-o-x-mark" class="h-4 w-4 mr-2" />
                                    Clear All
                                </a>
                            </div>
                        @endif
                    </div>
                </div>

                <!-- Active Filters -->
                @if (request()->hasAny(['search', 'category']))
                    <div class="mt-6 pt-6 border-t border-gray-200">
                        <div class="flex flex-wrap items-center gap-3">
                            <span class="text-sm font-medium text-gray-700 flex items-center">
                                <x-icon name="heroicon-o-funnel" class="h-4 w-4 mr-2" />
                                Active filters:
                            </span>

                            @if (request('search'))
                                <span
                                    class="inline-flex items-center px-3 py-1 rounded-full text-sm bg-amber-100 text-amber-800 border border-amber-200">
                                    <x-icon name="heroicon-o-magnifying-glass" class="h-3 w-3 mr-1" />
                                    Search: "{{ request('search') }}"
                                    <a href="{{ route('catalog.index', request()->except('search')) }}"
                                        class="ml-2 text-amber-600 hover:text-amber-800 transition-colors">
                                        <x-icon name="heroicon-o-x-mark" class="h-3 w-3" />
                                    </a>
                                </span>
                            @endif

                            @if (request('category'))
                                <span
                                    class="inline-flex items-center px-3 py-1 rounded-full text-sm bg-amber-100 text-amber-800 border border-amber-200">
                                    <x-icon name="heroicon-o-tag" class="h-3 w-3 mr-1" />
                                    Category: {{ $categories->where('slug', request('category'))->first()?->name }}
                                    <a href="{{ route('catalog.index', request()->except('category')) }}"
                                        class="ml-2 text-amber-600 hover:text-amber-800 transition-colors">
                                        <x-icon name="heroicon-o-x-mark" class="h-3 w-3" />
                                    </a>
                                </span>
                            @endif
                        </div>
                    </div>
                @endif
            </div>

            <!-- Results Summary -->
            <div class="mb-6 flex flex-col sm:flex-row sm:items-center sm:justify-between">
                <div class="flex items-center text-gray-600 mb-4 sm:mb-0">
                    <x-icon name="heroicon-o-squares-2x2" class="h-5 w-5 mr-2" />
                    <span>
                        Showing {{ $songkets->firstItem() ?? 0 }}-{{ $songkets->lastItem() ?? 0 }}
                        of {{ $songkets->total() }} results
                    </span>
                </div>

                <!-- View Toggle (Future enhancement) -->
                <div class="flex items-center space-x-2">
                    <span class="text-sm text-gray-500">View:</span>
                    <button class="p-2 text-amber-600 bg-amber-50 rounded-lg border border-amber-200">
                        <x-icon name="heroicon-o-squares-2x2" class="h-4 w-4" />
                    </button>
                    <button class="p-2 text-gray-400 hover:text-gray-600 rounded-lg border border-gray-200">
                        <x-icon name="heroicon-o-list-bullet" class="h-4 w-4" />
                    </button>
                </div>
            </div>

            <!-- Products Grid -->
            @if ($songkets->count() > 0)
                <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-3 xl:grid-cols-4 gap-6 mb-8">
                    @foreach ($songkets as $songket)
                        <x-product-card :songket="$songket" />
                    @endforeach
                </div>

                <!-- Pagination -->
                <div class="flex justify-center">
                    {{ $songkets->withQueryString()->links() }}
                </div>
            @else
                <!-- Empty State -->
                <div class="text-center py-16">
                    <div class="mx-auto w-24 h-24 bg-gray-100 rounded-full flex items-center justify-center mb-6">
                        <x-icon name="heroicon-o-magnifying-glass" class="h-12 w-12 text-gray-400" />
                    </div>
                    <h3 class="text-xl font-semibold text-gray-900 mb-2">No products found</h3>
                    <p class="text-gray-600 mb-8 max-w-md mx-auto">
                        We couldn't find any products matching your search criteria.
                        Try adjusting your filters or search terms.
                    </p>

                    <div class="flex flex-col sm:flex-row gap-4 justify-center">
                        <a href="{{ route('catalog.index') }}"
                            class="inline-flex items-center px-6 py-3 bg-amber-500 hover:bg-amber-600 text-white rounded-lg font-medium transition-colors">
                            <x-icon name="heroicon-o-arrow-path" class="h-4 w-4 mr-2" />
                            View All Products
                        </a>

                        @if (request()->hasAny(['search', 'category']))
                            <a href="{{ route('catalog.index') }}"
                                class="inline-flex items-center px-6 py-3 bg-gray-100 hover:bg-gray-200 text-gray-700 rounded-lg font-medium transition-colors border border-gray-300">
                                <x-icon name="heroicon-o-x-mark" class="h-4 w-4 mr-2" />
                                Clear Filters
                            </a>
                        @endif
                    </div>
                </div>
            @endif
        </div>
    </div>
</x-app-layout>
