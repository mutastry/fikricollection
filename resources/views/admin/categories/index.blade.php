<x-admin-layout>
    <x-slot name="title">Manajemen Kategori</x-slot>

    <x-data-table title="Data Kategori" :data="$categories" :columns="[
        [
            'key' => 'image',
            'label' => 'Gambar',
            'component' => 'data-table.image-cell',
            'nowrap' => true,
        ],
        [
            'key' => 'name',
            'label' => 'Nama Kategori',
            'subtitle' => 'description',
            'class' => 'font-medium text-gray-900',
        ],
        [
            'key' => 'songkets_count',
            'label' => 'Jumlah Produk',
            'class' => 'text-gray-900',
        ],
        [
            'key' => 'is_active',
            'label' => 'Status',
            'format' => 'badge',
            'badge_colors' => [
                true => 'bg-green-100 text-green-800',
                false => 'bg-red-100 text-red-800',
            ],
            'badge_labels' => [
                true => 'Aktif',
                false => 'Tidak Aktif',
            ],
        ],
        [
            'key' => 'created_at',
            'label' => 'Dibuat',
            'format' => 'date',
        ],
    ]" :filters="[
        [
            'name' => 'status',
            'label' => 'Status',
            'type' => 'select',
            'placeholder' => 'Semua Status',
            'options' => [
                'active' => 'Aktif',
                'inactive' => 'Tidak Aktif',
            ],
        ],
    ]" :actions="[
        [
            'type' => 'link',
            'label' => 'Edit',
            'icon' => 'heroicon-o-pencil',
            'color' => 'amber',
            'url' => fn($item) => route('admin.categories.edit', $item),
            'tooltip' => 'Edit Kategori',
        ],
        [
            'type' => 'form',
            'label' => 'Hapus',
            'icon' => 'heroicon-o-trash',
            'color' => 'red',
            'method' => 'DELETE',
            'url' => fn($item) => route('admin.categories.destroy', $item),
            'confirm' => 'Apakah Anda yakin ingin menghapus kategori ini?',
            'tooltip' => 'Hapus Kategori',
            'condition' => fn($item) => $item->songkets_count == 0,
        ],
    ]"
        create-route="{{ route('admin.categories.create') }}" create-label="Tambah Kategori"
        search-placeholder="Cari nama kategori..." empty-message="Belum ada data kategori" :searchable="true"
        :filterable="true" :exportable="false" />
</x-admin-layout>
