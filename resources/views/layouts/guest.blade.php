<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">

<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <meta name="csrf-token" content="{{ csrf_token() }}">

    <title>{{ $title ?? 'Palembang Songket Store' }}</title>

    <!-- Fonts -->
    <link rel="preconnect" href="https://fonts.bunny.net">
    <link href="https://fonts.bunny.net/css?family=figtree:400,500,600&display=swap" rel="stylesheet" />
    <link href="https://fonts.googleapis.com/css2?family=Playfair+Display:wght@400;500;600;700&display=swap"
        rel="stylesheet">

    <!-- Scripts -->
    @vite(['resources/css/app.css', 'resources/js/app.js'])
</head>

<body class="font-sans text-gray-900 antialiased">
    <div class="min-h-screen flex">
        <!-- Left Side - Branding/Image -->
        <div
            class="hidden lg:flex lg:w-1/2 bg-gradient-to-br from-amber-600 via-orange-600 to-red-600 relative overflow-hidden">
            <!-- Background Pattern -->
            <div class="absolute inset-0 bg-black opacity-20"></div>
            <div class="absolute inset-0 bg-gradient-to-r from-transparent via-amber-900/20 to-transparent"></div>

            <!-- Decorative Elements -->
            <div class="absolute top-10 left-10 w-32 h-32 bg-amber-300 rounded-full opacity-20 animate-pulse"></div>
            <div
                class="absolute bottom-20 right-20 w-24 h-24 bg-orange-300 rounded-full opacity-30 animate-pulse delay-1000">
            </div>
            <div class="absolute top-1/3 right-10 w-16 h-16 bg-red-300 rounded-full opacity-25 animate-pulse delay-500">
            </div>

            <!-- Content -->
            <div class="relative z-10 flex flex-col justify-center items-center w-full p-12 text-white">
                <!-- Logo -->
                <div class="mb-8">
                    <div
                        class="w-20 h-20 bg-white bg-opacity-20 backdrop-blur-sm rounded-2xl flex items-center justify-center shadow-2xl">
                        <span class="text-white font-bold text-3xl font-serif">S</span>
                    </div>
                </div>

                <!-- Main Heading -->
                <h1 class="text-4xl md:text-5xl font-bold font-serif mb-6 text-center leading-tight">
                    Warisan <span class="text-amber-200">Songket</span> Palembang
                </h1>

                <!-- Description -->
                <p class="text-xl md:text-2xl mb-8 text-amber-100 text-center leading-relaxed max-w-md">
                    Discover the timeless beauty of traditional Palembang Songket, woven with gold threads and centuries
                    of heritage.
                </p>

                <!-- Features -->
                <div class="space-y-4 text-center">
                    <div class="flex items-center justify-center text-amber-100">
                        <svg class="w-5 h-5 mr-3 text-amber-300" fill="none" stroke="currentColor"
                            viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M5 13l4 4L19 7">
                            </path>
                        </svg>
                        Authentic Handwoven Songket
                    </div>
                    <div class="flex items-center justify-center text-amber-100">
                        <svg class="w-5 h-5 mr-3 text-amber-300" fill="none" stroke="currentColor"
                            viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M5 13l4 4L19 7">
                            </path>
                        </svg>
                        500+ Years of Heritage
                    </div>
                    <div class="flex items-center justify-center text-amber-100">
                        <svg class="w-5 h-5 mr-3 text-amber-300" fill="none" stroke="currentColor"
                            viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M5 13l4 4L19 7">
                            </path>
                        </svg>
                        Master Artisan Craftsmanship
                    </div>
                </div>

                <!-- Songket Image Placeholder -->
                <div class="mt-12 relative">
                    <div class="w-64 h-64 bg-white bg-opacity-10 backdrop-blur-sm rounded-full p-8 shadow-2xl">
                        <img src="/placeholder.svg?height=200&width=200" alt="Traditional Songket"
                            class="w-full h-full object-cover rounded-full opacity-80">
                    </div>
                    <!-- Floating elements around the image -->
                    <div class="absolute -top-2 -right-2 w-8 h-8 bg-amber-300 rounded-full opacity-60 animate-bounce">
                    </div>
                    <div
                        class="absolute -bottom-2 -left-2 w-6 h-6 bg-orange-300 rounded-full opacity-60 animate-bounce delay-300">
                    </div>
                </div>
            </div>
        </div>

        <!-- Right Side - Form -->
        <div class="w-full lg:w-1/2 flex flex-col justify-center items-center p-6 lg:p-12 bg-gray-50">
            <!-- Mobile Logo (visible only on small screens) -->
            <div class="lg:hidden mb-8">
                <x-application-logo class="justify-center" />
            </div>

            <!-- Form Container -->
            <div class="w-full max-w-md">
                {{ $slot }}
            </div>

            <!-- Footer Links -->
            <div class="mt-8 text-center">
                <a href="{{ route('home') }}" class="text-sm text-gray-600 hover:text-amber-600 transition-colors">
                    ← Back to Store
                </a>
            </div>
        </div>
    </div>

</body>

</html>
