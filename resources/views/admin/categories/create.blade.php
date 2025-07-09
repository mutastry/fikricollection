<x-admin-layout>
    <x-slot name="title">Tambah Kategori</x-slot>

    <div class="max-w-2xl mx-auto">
        <div class="bg-white shadow-sm rounded-lg">
            <div class="px-6 py-4 border-b border-gray-200">
                <h2 class="text-lg font-medium text-gray-900">Tambah Kategori Baru</h2>
                <p class="mt-1 text-sm text-gray-600">Isi form di bawah untuk menambahkan kategori songket baru.</p>
            </div>

            <form action="{{ route('admin.categories.store') }}" method="POST" enctype="multipart/form-data"
                class="p-6">
                @csrf

                <div class="space-y-6">
                    <!-- Name -->
                    <div>
                        <x-input-label for="name" :value="__('Nama Kategori')" />
                        <x-text-input id="name" name="name" type="text" class="mt-1 block w-full"
                            :value="old('name')" required />
                        <x-input-error class="mt-2" :messages="$errors->get('name')" />
                    </div>

                    <!-- Description -->
                    <div>
                        <x-input-label for="description" :value="__('Deskripsi')" />
                        <textarea id="description" name="description" rows="4"
                            class="mt-1 block w-full border-gray-300 rounded-md shadow-sm focus:border-amber-500 focus:ring-amber-500">{{ old('description') }}</textarea>
                        <x-input-error class="mt-2" :messages="$errors->get('description')" />
                        <p class="mt-1 text-sm text-gray-500">Opsional. Deskripsi singkat tentang kategori ini.</p>
                    </div>

                    <!-- Image Upload -->
                    <x-image-upload name="image" label="Gambar Kategori" :multiple="false" :max-files="1"
                        :max-size="2048"
                        help="Format: JPEG, PNG, JPG, WebP. Maksimal 2MB. Gambar akan digunakan sebagai thumbnail kategori." />

                    <!-- Status -->
                    <div>
                        <label class="flex items-center">
                            <input type="checkbox" name="is_active" value="1"
                                {{ old('is_active', true) ? 'checked' : '' }}
                                class="rounded border-gray-300 text-amber-600 shadow-sm focus:ring-amber-500" />
                            <span class="ml-2 text-sm text-gray-600">Kategori aktif</span>
                        </label>
                        <x-input-error class="mt-2" :messages="$errors->get('is_active')" />
                        <p class="mt-1 text-sm text-gray-500">Kategori yang tidak aktif tidak akan ditampilkan di
                            website.</p>
                    </div>
                </div>

                <!-- Actions -->
                <div class="flex items-center justify-end space-x-3 pt-6 mt-6 border-t border-gray-200">
                    <a href="{{ route('admin.categories.index') }}"
                        class="inline-flex items-center px-4 py-2 border border-gray-300 rounded-md shadow-sm text-sm font-medium text-gray-700 bg-white hover:bg-gray-50 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-amber-500">
                        Batal
                    </a>
                    <x-primary-button>
                        Simpan Kategori
                    </x-primary-button>
                </div>
            </form>
        </div>
    </div>
</x-admin-layout>
