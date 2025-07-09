<x-admin-layout>
    <x-slot name="title">Detail Songket</x-slot>

    <div class="max-w-6xl mx-auto">
        <!-- Header -->
        <div class="bg-white shadow-sm rounded-lg mb-6">
            <div class="px-6 py-4 border-b border-gray-200 flex items-center justify-between">
                <div>
                    <h2 class="text-lg font-medium text-gray-900">{{ $songket->name }}</h2>
                    <p class="mt-1 text-sm text-gray-600">Detail informasi produk songket</p>
                </div>
                <div class="flex items-center space-x-3">
                    @if (auth()->user()->canAccess('manage_songkets'))
                        <a href="{{ route('admin.songket.edit', $songket) }}"
                            class="inline-flex items-center px-4 py-2 border border-gray-300 rounded-md shadow-sm text-sm font-medium text-gray-700 bg-white hover:bg-gray-50 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-amber-500">
                            <svg class="w-4 h-4 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                    d="M11 5H6a2 2 0 00-2 2v11a2 2 0 002 2h11a2 2 0 002-2v-5m-1.414-9.414a2 2 0 112.828 2.828L11.828 15H9v-2.828l8.586-8.586z">
                                </path>
                            </svg>
                            Edit
                        </a>
                    @endif
                    <a href="{{ route('admin.songket.index') }}"
                        class="inline-flex items-center px-4 py-2 bg-amber-600 border border-transparent rounded-md font-semibold text-xs text-white uppercase tracking-widest hover:bg-amber-700 focus:bg-amber-700 active:bg-amber-900 focus:outline-none focus:ring-2 focus:ring-amber-500 focus:ring-offset-2 transition ease-in-out duration-150">
                        Kembali
                    </a>
                </div>
            </div>
        </div>

        <div class="grid grid-cols-1 lg:grid-cols-3 gap-6">
            <!-- Main Content -->
            <div class="lg:col-span-2 space-y-6">
                <!-- Product Images -->
                @if ($songket->images && count($songket->images) > 0)
                    <div class="bg-white shadow-sm rounded-lg p-6">
                        <h3 class="text-lg font-medium text-gray-900 mb-4">Gambar Produk</h3>
                        <div class="grid grid-cols-2 md:grid-cols-3 gap-4">
                            @foreach ($songket->images as $image)
                                <div class="aspect-square">
                                    <img src="{{ $image }}" alt="{{ $songket->name }}"
                                        class="w-full h-full object-cover rounded-lg border border-gray-200">
                                </div>
                            @endforeach
                        </div>
                    </div>
                @endif

                <!-- Product Details -->
                <div class="bg-white shadow-sm rounded-lg p-6">
                    <h3 class="text-lg font-medium text-gray-900 mb-4">Informasi Produk</h3>
                    <dl class="grid grid-cols-1 gap-4 sm:grid-cols-2">
                        <div>
                            <dt class="text-sm font-medium text-gray-500">Nama Songket</dt>
                            <dd class="mt-1 text-sm text-gray-900">{{ $songket->name }}</dd>
                        </div>
                        <div>
                            <dt class="text-sm font-medium text-gray-500">Kategori</dt>
                            <dd class="mt-1 text-sm text-gray-900">{{ $songket->category->name }}</dd>
                        </div>
                        <div>
                            <dt class="text-sm font-medium text-gray-500">Harga</dt>
                            <dd class="mt-1 text-sm text-gray-900 font-medium">Rp
                                {{ number_format($songket->base_price, 0, ',', '.') }}</dd>
                        </div>
                        <div>
                            <dt class="text-sm font-medium text-gray-500">Stok</dt>
                            <dd class="mt-1 text-sm text-gray-900">{{ $songket->stock_quantity }} unit</dd>
                        </div>
                        <div>
                            <dt class="text-sm font-medium text-gray-500">Status</dt>
                            <dd class="mt-1">
                                <span
                                    class="inline-flex items-center px-2.5 py-0.5 rounded-full text-xs font-medium {{ $songket->is_active ? 'bg-green-100 text-green-800' : 'bg-red-100 text-red-800' }}">
                                    {{ $songket->is_active ? 'Aktif' : 'Tidak Aktif' }}
                                </span>
                            </dd>
                        </div>
                        <div>
                            <dt class="text-sm font-medium text-gray-500">Unggulan</dt>
                            <dd class="mt-1">
                                <span
                                    class="inline-flex items-center px-2.5 py-0.5 rounded-full text-xs font-medium {{ $songket->is_featured ? 'bg-yellow-100 text-yellow-800' : 'bg-gray-100 text-gray-800' }}">
                                    {{ $songket->is_featured ? 'Ya' : 'Tidak' }}
                                </span>
                            </dd>
                        </div>
                        <div class="sm:col-span-2">
                            <dt class="text-sm font-medium text-gray-500">Deskripsi</dt>
                            <dd class="mt-1 text-sm text-gray-900">{{ $songket->description }}</dd>
                        </div>
                        @if ($songket->colors && count($songket->colors) > 0)
                            <div class="sm:col-span-2">
                                <dt class="text-sm font-medium text-gray-500">Pilihan Warna</dt>
                                <dd class="mt-1">
                                    <div class="flex flex-wrap gap-2">
                                        @foreach ($songket->colors as $color)
                                            <span
                                                class="inline-flex items-center px-2.5 py-0.5 rounded-full text-xs font-medium bg-blue-100 text-blue-800">
                                                {{ $color }}
                                            </span>
                                        @endforeach
                                    </div>
                                </dd>
                            </div>
                        @endif
                        @if ($songket->sizes && count($songket->sizes) > 0)
                            <div class="sm:col-span-2">
                                <dt class="text-sm font-medium text-gray-500">Pilihan Ukuran</dt>
                                <dd class="mt-1">
                                    <div class="flex flex-wrap gap-2">
                                        @foreach ($songket->sizes as $size)
                                            <span
                                                class="inline-flex items-center px-2.5 py-0.5 rounded-full text-xs font-medium bg-purple-100 text-purple-800">
                                                {{ $size }}
                                            </span>
                                        @endforeach
                                    </div>
                                </dd>
                            </div>
                        @endif
                    </dl>
                </div>

                <!-- Reviews -->
                @if ($songket->reviews->count() > 0)
                    <div class="bg-white shadow-sm rounded-lg p-6">
                        <h3 class="text-lg font-medium text-gray-900 mb-4">Ulasan Pelanggan
                            ({{ $songket->reviews->count() }})</h3>
                        <div class="space-y-4">
                            @foreach ($songket->reviews->take(5) as $review)
                                <div class="border-b border-gray-200 pb-4 last:border-b-0 last:pb-0">
                                    <div class="flex items-center justify-between mb-2">
                                        <div class="flex items-center">
                                            <div class="flex items-center">
                                                @for ($i = 1; $i <= 5; $i++)
                                                    <svg class="w-4 h-4 {{ $i <= $review->rating ? 'text-yellow-400' : 'text-gray-300' }}"
                                                        fill="currentColor" viewBox="0 0 20 20">
                                                        <path
                                                            d="M9.049 2.927c.3-.921 1.603-.921 1.902 0l1.07 3.292a1 1 0 00.95.69h3.462c.969 0 1.371 1.24.588 1.81l-2.8 2.034a1 1 0 00-.364 1.118l1.07 3.292c.3.921-.755 1.688-1.54 1.118l-2.8-2.034a1 1 0 00-1.175 0l-2.8 2.034c-.784.57-1.838-.197-1.539-1.118l1.07-3.292a1 1 0 00-.364-1.118L2.98 8.72c-.783-.57-.38-1.81.588-1.81h3.461a1 1 0 00.951-.69l1.07-3.292z">
                                                        </path>
                                                    </svg>
                                                @endfor
                                            </div>
                                            <span
                                                class="ml-2 text-sm font-medium text-gray-900">{{ $review->user->name }}</span>
                                        </div>
                                        <span
                                            class="text-sm text-gray-500">{{ $review->created_at->format('d M Y') }}</span>
                                    </div>
                                    <p class="text-sm text-gray-700">{{ $review->comment }}</p>
                                </div>
                            @endforeach
                        </div>
                    </div>
                @endif
            </div>

            <!-- Sidebar -->
            <div class="space-y-6">
                <!-- Statistics -->
                <div class="bg-white shadow-sm rounded-lg p-6">
                    <h3 class="text-lg font-medium text-gray-900 mb-4">Statistik</h3>
                    <dl class="space-y-3">
                        <div class="flex justify-between">
                            <dt class="text-sm text-gray-500">Total Terjual</dt>
                            <dd class="text-sm font-medium text-gray-900">{{ $songket->orderItems->sum('quantity') }}
                                unit</dd>
                        </div>
                        <div class="flex justify-between">
                            <dt class="text-sm text-gray-500">Total Pendapatan</dt>
                            <dd class="text-sm font-medium text-gray-900">Rp
                                {{ number_format($songket->orderItems->sum(function ($item) {return $item->quantity * $item->price;}),0,',','.') }}
                            </dd>
                        </div>
                        <div class="flex justify-between">
                            <dt class="text-sm text-gray-500">Rating Rata-rata</dt>
                            <dd class="text-sm font-medium text-gray-900">
                                @if ($songket->reviews->count() > 0)
                                    {{ number_format($songket->reviews->avg('rating'), 1) }}/5
                                @else
                                    Belum ada rating
                                @endif
                            </dd>
                        </div>
                        <div class="flex justify-between">
                            <dt class="text-sm text-gray-500">Jumlah Ulasan</dt>
                            <dd class="text-sm font-medium text-gray-900">{{ $songket->reviews->count() }}</dd>
                        </div>
                    </dl>
                </div>

                <!-- Recent Orders -->
                @if ($songket->orderItems->count() > 0)
                    <div class="bg-white shadow-sm rounded-lg p-6">
                        <h3 class="text-lg font-medium text-gray-900 mb-4">Pesanan Terbaru</h3>
                        <div class="space-y-3">
                            @foreach ($songket->orderItems->take(5) as $orderItem)
                                <div class="flex justify-between items-center">
                                    <div>
                                        <p class="text-sm font-medium text-gray-900">
                                            #{{ $orderItem->order->order_number }}</p>
                                        <p class="text-xs text-gray-500">{{ $orderItem->quantity }} unit × Rp
                                            {{ number_format($orderItem->price, 0, ',', '.') }}</p>
                                    </div>
                                    <div class="text-right">
                                        <span
                                            class="inline-flex items-center px-2 py-1 rounded-full text-xs font-medium {{ $orderItem->order->status->value === 'completed'
                                                ? 'bg-green-100 text-green-800'
                                                : ($orderItem->order->status->value === 'cancelled'
                                                    ? 'bg-red-100 text-red-800'
                                                    : 'bg-yellow-100 text-yellow-800') }}">
                                            {{ $orderItem->order->status->getLabel() }}
                                        </span>
                                        <p class="text-xs text-gray-500 mt-1">
                                            {{ $orderItem->order->created_at->format('d M Y') }}</p>
                                    </div>
                                </div>
                            @endforeach
                        </div>
                    </div>
                @endif

                <!-- Metadata -->
                <div class="bg-white shadow-sm rounded-lg p-6">
                    <h3 class="text-lg font-medium text-gray-900 mb-4">Metadata</h3>
                    <dl class="space-y-3">
                        <div>
                            <dt class="text-sm text-gray-500">Slug</dt>
                            <dd class="text-sm text-gray-900 font-mono">{{ $songket->slug }}</dd>
                        </div>
                        <div>
                            <dt class="text-sm text-gray-500">Dibuat</dt>
                            <dd class="text-sm text-gray-900">{{ $songket->created_at->format('d M Y H:i') }}</dd>
                        </div>
                        <div>
                            <dt class="text-sm text-gray-500">Diperbarui</dt>
                            <dd class="text-sm text-gray-900">{{ $songket->updated_at->format('d M Y H:i') }}</dd>
                        </div>
                    </dl>
                </div>
            </div>
        </div>
    </div>
</x-admin-layout>
