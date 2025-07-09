<x-admin-layout>
    <x-slot name="title">Manajemen Songket</x-slot>

    <x-data-table title="Data Songket" :data="$songkets" :columns="[
        [
            'key' => 'images',
            'label' => 'Gambar',
            'component' => 'data-table.image-cell',
            'nowrap' => true,
        ],
        [
            'key' => 'name',
            'label' => 'Nama Songket',
            'subtitle' => 'category.name',
            'class' => 'font-medium text-gray-900',
        ],
        [
            'key' => 'base_price',
            'label' => 'Harga',
            'format' => 'currency',
            'class' => 'font-medium text-gray-900',
        ],
        [
            'key' => 'stock_quantity',
            'label' => 'Stok',
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
            'key' => 'is_featured',
            'label' => 'Unggulan',
            'format' => 'boolean',
        ],
        [
            'key' => 'created_at',
            'label' => 'Dibuat',
            'format' => 'date',
        ],
    ]" :filters="[
        [
            'name' => 'category',
            'label' => 'Kategori',
            'type' => 'select',
            'placeholder' => 'Semua Kategori',
            'options' => $categories->pluck('name', 'id')->toArray(),
        ],
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
            'label' => 'Lihat',
            'icon' => 'heroicon-o-eye',
            'color' => 'blue',
            'url' => fn($item) => route('admin.songket.show', $item),
            'tooltip' => 'Lihat Detail',
        ],
        [
            'type' => 'link',
            'label' => 'Edit',
            'icon' => 'heroicon-o-pencil',
            'color' => 'amber',
            'url' => fn($item) => route('admin.songket.edit', $item),
            'tooltip' => 'Edit Songket',
            'condition' => fn($item) => auth()->user()->canAccess('manage_songkets'),
        ],
        [
            'type' => 'form',
            'label' => 'Toggle Status',
            'icon' => 'heroicon-o-arrow-path',
            'color' => 'green',
            'method' => 'PATCH',
            'url' => fn($item) => route('admin.songket.toggle-status', $item),
            'tooltip' => 'Ubah Status',
            'condition' => fn($item) => auth()->user()->canAccess('manage_songkets'),
        ],
        [
            'type' => 'form',
            'label' => 'Hapus',
            'icon' => 'heroicon-o-trash',
            'color' => 'red',
            'method' => 'DELETE',
            'url' => fn($item) => route('admin.songket.destroy', $item),
            'confirm' => 'Apakah Anda yakin ingin menghapus songket ini?',
            'tooltip' => 'Hapus Songket',
            'condition' => fn($item) => auth()->user()->canAccess('manage_songkets'),
        ],
    ]"
        create-route="{{ auth()->user()->canAccess('manage_songkets') ? route('admin.songket.create') : null }}"
        create-label="Tambah Songket"
        export-route="{{ auth()->user()->canAccess('export_songkets') ? route('admin.songket.export', request()->query()) : null }}"
        search-placeholder="Cari nama songket..." empty-message="Belum ada data songket" />
</x-admin-layout>
