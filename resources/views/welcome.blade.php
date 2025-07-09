<x-app-layout>
    <x-slot name="title">Home - Palembang Songket Store</x-slot>

    <!-- Hero Section -->
    <section class="relative bg-gradient-to-r from-amber-600 via-orange-600 to-red-600 text-white overflow-hidden">
        <div class="absolute inset-0 bg-black opacity-20"></div>
        <div class="absolute inset-0 bg-gradient-to-r from-transparent via-amber-900/20 to-transparent"></div>

        <div class="relative max-w-7xl mx-auto px-4 sm:px-6 lg:px-8 py-24 lg:py-32">
            <div class="grid grid-cols-1 lg:grid-cols-2 gap-12 items-center">
                <div class="text-center lg:text-left">
                    <h1 class="text-4xl md:text-6xl font-bold font-serif mb-6 leading-tight">
                        Warisan <span class="text-amber-200">Songket</span> Palembang
                    </h1>
                    <p class="text-xl md:text-2xl mb-8 text-amber-100 leading-relaxed">
                        Discover the timeless beauty of traditional Palembang Songket, woven with gold threads and
                        centuries of heritage.
                    </p>
                    <div class="flex flex-col sm:flex-row gap-4 justify-center lg:justify-start">
                        <a href="{{ route('catalog.index') }}"
                            class="bg-white text-amber-600 px-8 py-4 rounded-lg font-semibold text-lg hover:bg-amber-50 transition-colors shadow-lg">
                            Explore Collection
                        </a>
                        <a href="#heritage"
                            class="border-2 border-white text-white px-8 py-4 rounded-lg font-semibold text-lg hover:bg-white hover:text-amber-600 transition-colors">
                            Learn Heritage
                        </a>
                    </div>
                </div>
                <div class="relative">
                    <div
                        class="aspect-square rounded-full bg-gradient-to-br from-amber-400 to-orange-500 p-8 shadow-2xl">
                        <img src="/placeholder.svg?height=400&width=400" alt="Traditional Songket"
                            class="w-full h-full object-cover rounded-full">
                    </div>
                    <div class="absolute -top-4 -right-4 w-24 h-24 bg-amber-300 rounded-full opacity-60 animate-pulse">
                    </div>
                    <div
                        class="absolute -bottom-4 -left-4 w-16 h-16 bg-orange-300 rounded-full opacity-60 animate-pulse delay-1000">
                    </div>
                </div>
            </div>
        </div>
    </section>

    <!-- Featured Products -->
    <section class="py-16 bg-white">
        <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
            <div class="text-center mb-12">
                <h2 class="text-3xl md:text-4xl font-bold text-gray-900 font-serif mb-4">Featured Songket</h2>
                <p class="text-xl text-gray-600 max-w-2xl mx-auto">Handpicked masterpieces showcasing the finest
                    craftsmanship of Palembang artisans</p>
            </div>

            <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-3 gap-8">
                @foreach ($featuredSongkets as $songket)
                    <x-product-card :songket="$songket" />
                @endforeach
            </div>

            <div class="text-center mt-12">
                <a href="{{ route('catalog.index') }}"
                    class="inline-flex items-center bg-amber-500 hover:bg-amber-600 text-white px-8 py-3 rounded-lg font-semibold transition-colors">
                    View All Songket
                    <svg class="ml-2 w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                            d="M17 8l4 4m0 0l-4 4m4-4H3"></path>
                    </svg>
                </a>
            </div>
        </div>
    </section>

    <!-- Heritage Section -->
    <section id="heritage" class="py-16 bg-gradient-to-br from-amber-50 to-orange-50">
        <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
            <div class="grid grid-cols-1 lg:grid-cols-2 gap-12 items-center">
                <div>
                    <h2 class="text-3xl md:text-4xl font-bold text-gray-900 font-serif mb-6">The Heritage of Palembang
                        Songket</h2>
                    <div class="space-y-4 text-gray-700 text-lg leading-relaxed">
                        <p>
                            Songket Palembang is a traditional Indonesian textile that represents centuries of cultural
                            heritage and artistic excellence. Each piece is meticulously handwoven with gold and silver
                            threads, creating intricate patterns that tell stories of our ancestors.
                        </p>
                        <p>
                            Originating from the Sultanate of Palembang, these textiles were once reserved for royalty
                            and special ceremonies. Today, we preserve this ancient craft while making it accessible to
                            those who appreciate true artistry.
                        </p>
                        <p>
                            Every Songket in our collection is created by skilled artisans who have inherited techniques
                            passed down through generations, ensuring authenticity and unmatched quality.
                        </p>
                    </div>
                    <div class="mt-8 grid grid-cols-2 gap-6">
                        <div class="text-center">
                            <div class="text-3xl font-bold text-amber-600">500+</div>
                            <div class="text-gray-600">Years of Heritage</div>
                        </div>
                        <div class="text-center">
                            <div class="text-3xl font-bold text-amber-600">100%</div>
                            <div class="text-gray-600">Handwoven</div>
                        </div>
                    </div>
                </div>
                <div class="relative">
                    <img src="/placeholder.svg?height=500&width=600" alt="Songket Weaving Process"
                        class="rounded-lg shadow-xl">
                    <div class="absolute inset-0 bg-gradient-to-t from-black/20 to-transparent rounded-lg"></div>
                </div>
            </div>
        </div>
    </section>

    <!-- Categories -->
    <section class="py-16 bg-white">
        <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
            <div class="text-center mb-12">
                <h2 class="text-3xl md:text-4xl font-bold text-gray-900 font-serif mb-4">Explore Categories</h2>
                <p class="text-xl text-gray-600">Discover different styles and patterns of traditional Songket</p>
            </div>

            <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-4 gap-6">
                @foreach ($categories as $category)
                    <a href="{{ route('catalog.index', ['category' => $category->slug]) }}"
                        class="group relative overflow-hidden rounded-lg shadow-lg hover:shadow-xl transition-shadow">
                        <div class="aspect-square bg-gradient-to-br from-amber-400 to-orange-500">
                            <img src="{{ $category->image ?? '/placeholder.svg?height=300&width=300' }}"
                                alt="{{ $category->name }}"
                                class="w-full h-full object-cover group-hover:scale-105 transition-transform duration-300">
                        </div>
                        <div class="absolute inset-0 bg-gradient-to-t from-black/60 to-transparent"></div>
                        <div class="absolute bottom-4 left-4 right-4">
                            <h3 class="text-white font-semibold text-lg">{{ $category->name }}</h3>
                            <p class="text-amber-200 text-sm">{{ $category->songkets_count }} Songket</p>
                        </div>
                    </a>
                @endforeach
            </div>
        </div>
    </section>
</x-app-layout>
