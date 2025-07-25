<footer class="bg-gray-900 text-white">
    <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8 py-12">
        <div class="grid grid-cols-1 md:grid-cols-4 gap-8">
            <!-- Brand -->
            <div class="col-span-1 md:col-span-2">
                <div class="flex items-center mb-4">
                    <div
                        class="w-10 h-10 bg-gradient-to-br from-amber-500 to-orange-600 rounded-lg flex items-center justify-center">
                        <span class="text-white font-bold text-lg font-serif">S</span>
                    </div>
                    <span class="ml-2 text-xl font-bold font-serif">Songket Palembang</span>
                </div>
                <p class="text-gray-300 mb-4 max-w-md">
                    Preserving the heritage of traditional Palembang Songket through authentic, handwoven textiles
                    crafted by master artisans.
                </p>
                <div class="flex space-x-4">
                    <a href="#" class="text-gray-400 hover:text-amber-400 transition-colors">
                        <svg class="w-5 h-5" fill="currentColor" viewBox="0 0 24 24">
                            <path
                                d="M24 4.557c-.883.392-1.832.656-2.828.775 1.017-.609 1.798-1.574 2.165-2.724-.951.564-2.005.974-3.127 1.195-.897-.957-2.178-1.555-3.594-1.555-3.179 0-5.515 2.966-4.797 6.045-4.091-.205-7.719-2.165-10.148-5.144-1.29 2.213-.669 5.108 1.523 6.574-.806-.026-1.566-.247-2.229-.616-.054 2.281 1.581 4.415 3.949 4.89-.693.188-1.452.232-2.224.084.626 1.956 2.444 3.379 4.6 3.419-2.07 1.623-4.678 2.348-7.29 2.04 2.179 1.397 4.768 2.212 7.548 2.212 9.142 0 14.307-7.721 13.995-14.646.962-.695 1.797-1.562 2.457-2.549z" />
                        </svg>
                    </a>
                    <a href="#" class="text-gray-400 hover:text-amber-400 transition-colors">
                        <svg class="w-5 h-5" fill="currentColor" viewBox="0 0 24 24">
                            <path
                                d="M12.017 0C5.396 0 .029 5.367.029 11.987c0 5.079 3.158 9.417 7.618 11.174-.105-.949-.199-2.403.041-3.439.219-.937 1.406-5.957 1.406-5.957s-.359-.72-.359-1.781c0-1.663.967-2.911 2.168-2.911 1.024 0 1.518.769 1.518 1.688 0 1.029-.653 2.567-.992 3.992-.285 1.193.6 2.165 1.775 2.165 2.128 0 3.768-2.245 3.768-5.487 0-2.861-2.063-4.869-5.008-4.869-3.41 0-5.409 2.562-5.409 5.199 0 1.033.394 2.143.889 2.741.099.12.112.225.085.345-.09.375-.293 1.199-.334 1.363-.053.225-.172.271-.402.165-1.495-.69-2.433-2.878-2.433-4.646 0-3.776 2.748-7.252 7.92-7.252 4.158 0 7.392 2.967 7.392 6.923 0 4.135-2.607 7.462-6.233 7.462-1.214 0-2.357-.629-2.75-1.378l-.748 2.853c-.271 1.043-1.002 2.35-1.492 3.146C9.57 23.812 10.763 24.009 12.017 24.009c6.624 0 11.99-5.367 11.99-11.988C24.007 5.367 18.641.001.012.001z" />
                        </svg>
                    </a>
                </div>
            </div>

            <!-- Quick Links -->
            <div>
                <h3 class="text-lg font-semibold mb-4">Quick Links</h3>
                <ul class="space-y-2">
                    <li><a href="{{ route('home') }}"
                            class="text-gray-300 hover:text-amber-400 transition-colors">Home</a></li>
                    <li><a href="{{ route('catalog.index') }}"
                            class="text-gray-300 hover:text-amber-400 transition-colors">Catalog</a></li>
                    {{-- <li><a href="{{ route('about') }}" --}}
                    <li><a href="#heritage" class="text-gray-300 hover:text-amber-400 transition-colors">About Us</a>
                    </li>
                    <li><a href="#" class="text-gray-300 hover:text-amber-400 transition-colors">Contact</a></li>
                </ul>
            </div>

            <!-- Contact Info -->
            <div>
                <h3 class="text-lg font-semibold mb-4">Contact Info</h3>
                <ul class="space-y-2 text-gray-300">
                    <li class="flex items-center">
                        <x-icon name="heroicon-o-map-pin" class="h-4 w-4 mr-2" />
                        Jl. Ki Rangga Wirasantika Wirosentiko No.500, 30 Ilir, Kec. Ilir Bar. II, Kota Palembang, Sumatera Selatan 30129
                    </li>
                    <li class="flex items-center">
                        <x-icon name="heroicon-o-phone" class="h-4 w-4 mr-2" />
                        +62 711 123456
                    </li>
                    <li class="flex items-center">
                        <x-icon name="heroicon-o-envelope" class="h-4 w-4 mr-2" />
                        info@songketpalembang.com
                    </li>
                </ul>
            </div>
        </div>

        <div class="border-t border-gray-800 mt-8 pt-8 text-center text-gray-400">
            <p>&copy; {{ date('Y') }} Songket Palembang Store. All rights reserved.</p>
        </div>
    </div>
</footer>
