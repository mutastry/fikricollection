<x-admin-layout>
    <x-slot name="title">Order Details</x-slot>

    <div class="mb-6">
        <div class="flex items-center justify-between">
            <div>
                <h2 class="text-2xl font-bold text-gray-900">Order {{ $order->order_number }}</h2>
                <p class="text-gray-600">{{ $order->created_at->format('M d, Y H:i') }}</p>
            </div>
            <a href="{{ route('admin.orders.index') }}"
                class="bg-gray-500 hover:bg-gray-600 text-white px-4 py-2 rounded-lg font-medium transition-colors">
                Back to Orders
            </a>
        </div>
    </div>

    <div class="grid grid-cols-1 lg:grid-cols-3 gap-6">
        <!-- Order Details -->
        <div class="lg:col-span-2 space-y-6">
            <!-- Order Items -->
            <div class="bg-white rounded-lg shadow">
                <div class="px-6 py-4 border-b border-gray-200">
                    <h3 class="text-lg font-medium text-gray-900">Order Items</h3>
                </div>
                <div class="p-6">
                    <div class="space-y-4">
                        @foreach ($order->orderItems as $item)
                            <div class="flex items-center space-x-4">
                                <img src="{{ $item->songket->primary_image }}" alt="{{ $item->songket->name }}"
                                    class="w-16 h-16 object-cover rounded-lg">
                                <div class="flex-1">
                                    <h4 class="font-medium text-gray-900">{{ $item->songket->name }}</h4>
                                    <p class="text-sm text-gray-600">{{ $item->songket->category->name }}</p>
                                    @if ($item->selected_color || $item->selected_size)
                                        <div class="flex items-center space-x-4 mt-1">
                                            @if ($item->selected_color)
                                                <span class="text-xs text-gray-500">Color:
                                                    {{ ucfirst($item->selected_color) }}</span>
                                            @endif
                                            @if ($item->selected_size)
                                                <span class="text-xs text-gray-500">Size:
                                                    {{ $item->selected_size }}</span>
                                            @endif
                                        </div>
                                    @endif
                                </div>
                                <div class="text-right">
                                    <div class="font-medium text-gray-900">{{ $item->formatted_total_price }}</div>
                                    <div class="text-sm text-gray-500">Qty: {{ $item->quantity }} × Rp
                                        {{ number_format($item->price, 0, ',', '.') }}</div>
                                </div>
                            </div>
                        @endforeach
                    </div>

                    <div class="mt-6 pt-6 border-t border-gray-200">
                        <div class="flex justify-between">
                            <span class="text-lg font-semibold text-gray-900">Total</span>
                            <span class="text-lg font-bold text-amber-600">{{ $order->formatted_total_amount }}</span>
                        </div>
                    </div>
                </div>
            </div>

            <!-- Customer Information -->
            <div class="bg-white rounded-lg shadow">
                <div class="px-6 py-4 border-b border-gray-200">
                    <h3 class="text-lg font-medium text-gray-900">Customer Information</h3>
                </div>
                <div class="p-6">
                    <dl class="grid grid-cols-1 md:grid-cols-2 gap-4">
                        <div>
                            <dt class="text-sm font-medium text-gray-500">Name</dt>
                            <dd class="mt-1 text-sm text-gray-900">{{ $order->customer_name }}</dd>
                        </div>
                        <div>
                            <dt class="text-sm font-medium text-gray-500">Email</dt>
                            <dd class="mt-1 text-sm text-gray-900">{{ $order->customer_email }}</dd>
                        </div>
                        <div>
                            <dt class="text-sm font-medium text-gray-500">Phone</dt>
                            <dd class="mt-1 text-sm text-gray-900">{{ $order->customer_phone }}</dd>
                        </div>
                        <div class="md:col-span-2">
                            <dt class="text-sm font-medium text-gray-500">Address</dt>
                            <dd class="mt-1 text-sm text-gray-900">{{ $order->customer_address }}</dd>
                        </div>
                        @if ($order->notes)
                            <div class="md:col-span-2">
                                <dt class="text-sm font-medium text-gray-500">Notes</dt>
                                <dd class="mt-1 text-sm text-gray-900">{{ $order->notes }}</dd>
                            </div>
                        @endif
                    </dl>
                </div>
            </div>
        </div>

        <!-- Order Status & Actions -->
        <div class="space-y-6">
            <!-- Status Update -->
            <div class="bg-white rounded-lg shadow">
                <div class="px-6 py-4 border-b border-gray-200">
                    <h3 class="text-lg font-medium text-gray-900">Order Status</h3>
                </div>
                <div class="p-6">
                    <div class="mb-4">
                        <span
                            class="inline-flex px-3 py-1 text-sm font-semibold rounded-full bg-{{ $order->status->color() }}-100 text-{{ $order->status->color() }}-800">
                            {{ $order->status->label() }}
                        </span>
                    </div>

                    @php
                        $allowedTransitions = \App\Rules\StatusCanBeChanged::getAllowedTransitions(
                            $order->status,
                            'order',
                        );
                    @endphp

                    @if (empty($allowedTransitions))
                        <div class="bg-gray-50 border border-gray-200 rounded-lg p-4">
                            <div class="flex items-center">
                                <svg class="w-5 h-5 text-gray-400 mr-2" fill="none" stroke="currentColor"
                                    viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                        d="M13 16h-1v-4h-1m1-4h.01M21 12a9 9 0 11-18 0 9 9 0 0118 0z"></path>
                                </svg>
                                <p class="text-sm text-gray-600">
                                    @if ($order->status->value === 'completed')
                                        Pesanan ini telah selesai dan tidak dapat diubah statusnya.
                                    @elseif($order->status->value === 'canceled')
                                        Pesanan ini telah dibatalkan dan tidak dapat diubah statusnya.
                                    @else
                                        Status pesanan ini tidak dapat diubah saat ini.
                                    @endif
                                </p>
                            </div>
                        </div>
                    @else
                        <div class="space-y-3">
                            <p class="text-sm text-gray-600 mb-3">Pilih status baru untuk pesanan ini:</p>

                            @foreach ($allowedTransitions as $statusValue)
                                @php
                                    $statusEnum = \App\Enums\OrderStatus::from($statusValue);
                                    $statusLabel = $statusEnum->label();
                                    $statusColor = $statusEnum->color();
                                @endphp

                                <form method="POST" action="{{ route('admin.orders.update-status', $order) }}"
                                    class="inline-block w-full">
                                    @csrf
                                    @method('PATCH')
                                    <input type="hidden" name="status" value="{{ $statusValue }}">

                                    <button type="submit"
                                        onclick="return confirm('Apakah Anda yakin ingin mengubah status pesanan ke {{ $statusLabel }}?')"
                                        class="w-full flex items-center justify-between px-4 py-3 bg-white border border-gray-300 rounded-lg hover:bg-gray-50 focus:ring-2 focus:ring-amber-500 focus:border-transparent transition-colors group">
                                        <div class="flex items-center">
                                            <span
                                                class="inline-flex px-2 py-1 text-xs font-semibold rounded-full bg-{{ $statusColor }}-100 text-{{ $statusColor }}-800 mr-3">
                                                {{ $statusLabel }}
                                            </span>
                                            <span class="text-sm text-gray-700">
                                                @if ($statusValue === 'pending_payment')
                                                    Mulai memproses pesanan ini
                                                @elseif($statusValue === 'completed')
                                                    Selesaikan pesanan ini
                                                @elseif($statusValue === 'canceled')
                                                    Batalkan pesanan ini
                                                @else
                                                    Ubah ke {{ $statusLabel }}
                                                @endif
                                            </span>
                                        </div>
                                        <svg class="w-4 h-4 text-gray-400 group-hover:text-gray-600" fill="none"
                                            stroke="currentColor" viewBox="0 0 24 24">
                                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                                d="M9 5l7 7-7 7"></path>
                                        </svg>
                                    </button>
                                </form>
                            @endforeach
                        </div>
                    @endif
                </div>
            </div>

            <!-- Payment Information -->
            @if ($order->payment)
                <div class="bg-white rounded-lg shadow">
                    <div class="px-6 py-4 border-b border-gray-200">
                        <h3 class="text-lg font-medium text-gray-900">Payment Information</h3>
                    </div>
                    <div class="p-6">
                        <dl class="space-y-3">
                            <div>
                                <dt class="text-sm font-medium text-gray-500">Method</dt>
                                <dd class="mt-1 text-sm text-gray-900">{{ $order->payment->payment_method->label() }}
                                </dd>
                            </div>
                            <div>
                                <dt class="text-sm font-medium text-gray-500">Status</dt>
                                <dd class="mt-1">
                                    <span
                                        class="inline-flex px-2 py-1 text-xs font-semibold rounded-full bg-{{ $order->payment->payment_status->color() }}-100 text-{{ $order->payment->payment_status->color() }}-800">
                                        {{ $order->payment->payment_status->label() }}
                                    </span>
                                </dd>
                            </div>
                            <div>
                                <dt class="text-sm font-medium text-gray-500">Amount</dt>
                                <dd class="mt-1 text-sm text-gray-900">{{ $order->payment->formatted_amount }}</dd>
                            </div>
                            @if ($order->payment->payment_date)
                                <div>
                                    <dt class="text-sm font-medium text-gray-500">Payment Date</dt>
                                    <dd class="mt-1 text-sm text-gray-900">
                                        {{ $order->payment->payment_date->format('M d, Y H:i') }}</dd>
                                </div>
                            @endif
                        </dl>

                        @if ($order->payment->payment_proof)
                            <div class="mt-4">
                                <a href="{{ route('admin.payments.show', $order->payment) }}"
                                    class="text-amber-600 hover:text-amber-700 text-sm font-medium">
                                    View Payment Details →
                                </a>
                            </div>
                        @endif
                    </div>
                </div>
            @endif
        </div>
    </div>
</x-admin-layout>
