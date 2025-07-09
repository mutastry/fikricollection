<x-admin-layout>
    <x-slot name="title">Manajemen Pembayaran</x-slot>

    <x-data-table title="Data Pembayaran" :data="$payments" :columns="[
        [
            'key' => 'order.order_number',
            'label' => 'No. Pesanan',
            'class' => 'font-medium text-gray-900',
        ],
        [
            'key' => 'order.user',
            'label' => 'Pelanggan',
            'component' => 'data-table.user-cell',
        ],
        [
            'key' => 'payment_method',
            'label' => 'Metode',
            'format' => 'badge',
            'component' => 'data-table.status-badge',
        ],
        [
            'key' => 'amount',
            'label' => 'Jumlah',
            'format' => 'currency',
            'class' => 'font-medium text-gray-900',
        ],
        [
            'key' => 'payment_status',
            'label' => 'Status',
            'component' => 'data-table.status-badge',
            'status_colors' => [
                'pending' => 'yellow',
                'waiting_verification' => 'blue',
                'paid' => 'green',
                'failed' => 'red',
            ],
        ],
        [
            'key' => 'payment_date',
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
                'waiting_verification' => 'Menunggu Verifikasi',
                'paid' => 'Dibayar',
                'failed' => 'Gagal',
            ],
        ],
        [
            'name' => 'method',
            'label' => 'Metode',
            'type' => 'select',
            'placeholder' => 'Semua Metode',
            'options' => [
                'bank_transfer' => 'Transfer Bank',
                'qris' => 'QRIS',
                'e_wallet' => 'E-Wallet',
                'pay_in_store' => 'Bayar di Toko',
            ],
        ],
    ]" :actions="[
        [
            'type' => 'link',
            'label' => 'Lihat Detail',
            'icon' => 'heroicon-o-eye',
            'color' => 'amber',
            'url' => fn($item) => route('admin.payments.show', $item),
            'tooltip' => 'Lihat Detail Pembayaran',
        ],
    ]"
        export-route="{{ auth()->user()->canAccess('export_payments') ? route('admin.payments.export', request()->query()) : null }}"
        search-placeholder="Cari nomor pesanan atau nama pelanggan..." empty-message="Belum ada data pembayaran"
        :searchable="true" :filterable="true" :exportable="true" :create-route="null" />
</x-admin-layout>
