<x-admin-layout>
    <x-slot name="title">Tambah Songket</x-slot>

    <div class="max-w-4xl mx-auto">
        <div class="bg-white shadow-sm rounded-lg">
            <div class="px-6 py-4 border-b border-gray-200">
                <h2 class="text-lg font-medium text-gray-900">Tambah Songket Baru</h2>
                <p class="mt-1 text-sm text-gray-600">Isi form di bawah untuk menambahkan produk songket baru.</p>
            </div>

            <form action="{{ route('admin.songket.store') }}" method="POST" enctype="multipart/form-data" class="p-6">
                @csrf

                <div class="grid grid-cols-1 lg:grid-cols-2 gap-6">
                    <!-- Left Column -->
                    <div class="space-y-6">
                        <!-- Category -->
                        <div>
                            <x-input-label for="category_id" :value="__('Kategori')" />
                            <select id="category_id" name="category_id"
                                class="mt-1 block w-full border-gray-300 rounded-md shadow-sm focus:border-amber-500 focus:ring-amber-500"
                                required>
                                <option value="">Pilih Kategori</option>
                                @foreach ($categories as $category)
                                    <option value="{{ $category->id }}"
                                        {{ old('category_id') == $category->id ? 'selected' : '' }}>
                                        {{ $category->name }}
                                    </option>
                                @endforeach
                            </select>
                            <x-input-error class="mt-2" :messages="$errors->get('category_id')" />
                        </div>

                        <!-- Name -->
                        <div>
                            <x-input-label for="name" :value="__('Nama Songket')" />
                            <x-text-input id="name" name="name" type="text" class="mt-1 block w-full"
                                :value="old('name')" required />
                            <x-input-error class="mt-2" :messages="$errors->get('name')" />
                        </div>

                        <!-- Description -->
                        <div>
                            <x-input-label for="description" :value="__('Deskripsi')" />
                            <textarea id="description" name="description" rows="4"
                                class="mt-1 block w-full border-gray-300 rounded-md shadow-sm focus:border-amber-500 focus:ring-amber-500" required>{{ old('description') }}</textarea>
                            <x-input-error class="mt-2" :messages="$errors->get('description')" />
                            <p class="mt-1 text-sm text-gray-500">Minimal 10 karakter.</p>
                        </div>

                        <!-- Base Price -->
                        <div>
                            <x-input-label for="base_price" :value="__('Harga (Rp)')" />
                            <x-text-input id="base_price" name="base_price" type="number" min="1000" step="1000"
                                class="mt-1 block w-full" :value="old('base_price')" required />
                            <x-input-error class="mt-2" :messages="$errors->get('base_price')" />
                            <p class="mt-1 text-sm text-gray-500">Minimal Rp 1.000.</p>
                        </div>

                        <!-- Stock Quantity -->
                        <div>
                            <x-input-label for="stock_quantity" :value="__('Jumlah Stok')" />
                            <x-text-input id="stock_quantity" name="stock_quantity" type="number" min="0"
                                class="mt-1 block w-full" :value="old('stock_quantity', 0)" required />
                            <x-input-error class="mt-2" :messages="$errors->get('stock_quantity')" />
                        </div>
                    </div>

                    <!-- Right Column -->
                    <div class="space-y-6">
                        <!-- Colors -->
                        <div>
                            <x-input-label :value="__('Pilihan Warna')" />
                            <div id="colors-container" class="mt-1 space-y-2">
                                @if (old('colors'))
                                    @foreach (old('colors') as $index => $color)
                                        <div class="flex items-center space-x-2 color-input">
                                            <input name="colors[]" type="color" class="flex-1"
                                                value="{{ $color }}" placeholder="Contoh: Merah, Emas">
                                            <button type="button" onclick="removeColorInput(this)"
                                                class="px-3 py-2 text-red-600 hover:text-red-800">
                                                <svg class="w-4 h-4" fill="none" stroke="currentColor"
                                                    viewBox="0 0 24 24">
                                                    <path stroke-linecap="round" stroke-linejoin="round"
                                                        stroke-width="2" d="M6 18L18 6M6 6l12 12"></path>
                                                </svg>
                                            </button>
                                        </div>
                                    @endforeach
                                @else
                                    <div class="flex items-center space-x-2 color-input">
                                        <input name="colors[]" type="color" class="flex-1"
                                            placeholder="Contoh: Merah, Emas">
                                        <button type="button" onclick="removeColorInput(this)"
                                            class="px-3 py-2 text-red-600 hover:text-red-800">
                                            <svg class="w-4 h-4" fill="none" stroke="currentColor"
                                                viewBox="0 0 24 24">
                                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                                    d="M6 18L18 6M6 6l12 12"></path>
                                            </svg>
                                        </button>
                                    </div>
                                @endif
                            </div>
                            <button type="button" onclick="addColorInput()"
                                class="mt-2 text-sm text-amber-600 hover:text-amber-800">
                                + Tambah Warna
                            </button>
                            <x-input-error class="mt-2" :messages="$errors->get('colors')" />
                            <x-input-error class="mt-2" :messages="$errors->get('colors.*')" />
                        </div>


                        <!-- Images Upload Component -->
                        <x-image-upload name="images" label="Gambar Produk" :multiple="true" :max-files="5"
                            accept="image/*,.webp" :required="true" :max-size="2048"
                            help="Format: JPEG, PNG, JPG, WebP. Maksimal 5 gambar, masing-masing 2MB." />

                        <!-- Status Options -->
                        <div class="space-y-3">
                            <div>
                                <label class="flex items-center">
                                    <input type="checkbox" name="is_featured" value="1"
                                        {{ old('is_featured') ? 'checked' : '' }}
                                        class="rounded border-gray-300 text-amber-600 shadow-sm focus:ring-amber-500" />
                                    <span class="ml-2 text-sm text-gray-600">Produk unggulan</span>
                                </label>
                                <x-input-error class="mt-2" :messages="$errors->get('is_featured')" />
                            </div>

                            <div>
                                <label class="flex items-center">
                                    <input type="checkbox" name="is_active" value="1"
                                        {{ old('is_active', true) ? 'checked' : '' }}
                                        class="rounded border-gray-300 text-amber-600 shadow-sm focus:ring-amber-500" />
                                    <span class="ml-2 text-sm text-gray-600">Produk aktif</span>
                                </label>
                                <x-input-error class="mt-2" :messages="$errors->get('is_active')" />
                            </div>
                        </div>
                    </div>
                </div>

                <!-- Actions -->
                <div class="flex items-center justify-end space-x-3 pt-6 mt-6 border-t border-gray-200">
                    <a href="{{ route('admin.songket.index') }}"
                        class="inline-flex items-center px-4 py-2 border border-gray-300 rounded-md shadow-sm text-sm font-medium text-gray-700 bg-white hover:bg-gray-50 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-amber-500">
                        Batal
                    </a>
                    <x-primary-button>
                        Simpan Songket
                    </x-primary-button>
                </div>
            </form>
        </div>
    </div>

    <script>
        function addColorInput() {
            const container = document.getElementById('colors-container');
            const div = document.createElement('div');
            div.className = 'flex items-center space-x-2 color-input';
            div.innerHTML = `
                <input name="colors[]" type="color" class="flex-1 border-gray-300 rounded-md shadow-sm focus:border-amber-500 focus:ring-amber-500" placeholder="Contoh: Merah, Emas" />
                <button type="button" onclick="removeColorInput(this)" class="px-3 py-2 text-red-600 hover:text-red-800">
                    <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M6 18L18 6M6 6l12 12"></path>
                    </svg>
                </button>
            `;
            container.appendChild(div);
        }

        function removeColorInput(button) {
            const container = document.getElementById('colors-container');
            if (container.children.length > 1) {
                button.parentElement.remove();
            }
        }
    </script>
</x-admin-layout>
