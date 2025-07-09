<x-admin-layout>
    <x-slot name="title">Manajemen Pesanan</x-slot>

    <x-data-table title="Data Pesanan" :data="$orders" :columns="[
        [
            'key' => 'order_number',
            'label' => 'No. Pesanan',
            'class' => 'font-medium text-gray-900',
        ],
        [
            'key' => 'user',
            'label' => 'Pelanggan',
            'component' => 'data-table.user-cell',
        ],
        [
            'key' => 'order_items_count',
            'label' => 'Jumlah Item',
            'class' => 'text-gray-900',
        ],
        [
            'key' => 'total_amount',
            'label' => 'Total',
            'format' => 'currency',
            'class' => 'font-medium text-gray-900',
        ],
        [
            'key' => 'status',
            'label' => 'Status',
            'component' => 'data-table.status-badge',
            'status_colors' => [
                'pending' => 'yellow',
                'pending_payment' => 'orange',
                'ready_for_pickup' => 'blue',
                'completed' => 'green',
                'canceled' => 'red',
            ],
        ],
        [
            'key' => 'created_at',
            'label' => 'Tanggal',
            'format' => 'datetime',
        ],
    ]" :filters="[
        [
            'name' => 'status',
            'label' => 'Status',
            'type' => 'select',
            'placeholder' => 'Semua Status',
            'options' => [
                'pending' => 'Pending',
                'pending_payment' => 'Menunggu Pembayaran',
                'ready_for_pickup' => 'Siap Diambil',
                'completed' => 'Selesai',
                'canceled' => 'Dibatalkan',
            ],
        ],
        [
            'name' => 'date_from',
            'label' => 'Dari Tanggal',
            'type' => 'date',
        ],
        [
            'name' => 'date_to',
            'label' => 'Sampai Tanggal',
            'type' => 'date',
        ],
    ]" :actions="[
        [
            'type' => 'link',
            'label' => 'Lihat Detail',
            'icon' => 'heroicon-o-eye',
            'color' => 'amber',
            'url' => fn($item) => route('admin.orders.show', $item),
            'tooltip' => 'Lihat Detail Pesanan',
        ],
        [
            'type' => 'form',
            'label' => 'Hapus Pesanan',
            'icon' => 'heroicon-o-trash',
            'color' => 'red',
            'method' => 'DELETE',
            'url' => fn($item) => route('admin.orders.destroy', $item),
            'tooltip' => 'Hapus Pesanan',
            'confirm' => 'Anda yakin ingin menghapus pesanan ini?',
        ],
    ]"
        export-route="{{ auth()->user()->canAccess('export_orders') ? route('admin.orders.export', request()->query()) : null }}"
        search-placeholder="Cari nomor pesanan atau nama pelanggan..." empty-message="Belum ada data pesanan"
        :searchable="true" :filterable="true" :exportable="true" :create-route="null" />
</x-admin-layout>
