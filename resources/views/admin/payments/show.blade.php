<x-admin-layout>
    <x-slot name="title">Payment Details</x-slot>

    <div class="mb-6">
        <div class="flex items-center justify-between">
            <div>
                <h2 class="text-2xl font-bold text-gray-900">Payment for Order {{ $payment->order->order_number }}</h2>
                <p class="text-gray-600">{{ $payment->created_at->format('M d, Y H:i') }}</p>
            </div>
            <a href="{{ route('admin.payments.index') }}"
                class="bg-gray-500 hover:bg-gray-600 text-white px-4 py-2 rounded-lg font-medium transition-colors">
                Back to Payments
            </a>
        </div>
    </div>

    <div class="grid grid-cols-1 lg:grid-cols-3 gap-6">
        <!-- Payment Details -->
        <div class="lg:col-span-2 space-y-6">
            <!-- Payment Information -->
            <div class="bg-white rounded-lg shadow">
                <div class="px-6 py-4 border-b border-gray-200">
                    <h3 class="text-lg font-medium text-gray-900">Payment Information</h3>
                </div>
                <div class="p-6">
                    <dl class="grid grid-cols-1 md:grid-cols-2 gap-4">
                        <div>
                            <dt class="text-sm font-medium text-gray-500">Payment Method</dt>
                            <dd class="mt-1 text-sm text-gray-900">{{ $payment->payment_method->label() }}</dd>
                        </div>
                        <div>
                            <dt class="text-sm font-medium text-gray-500">Amount</dt>
                            <dd class="mt-1 text-sm font-medium text-gray-900">{{ $payment->formatted_amount }}</dd>
                        </div>
                        <div>
                            <dt class="text-sm font-medium text-gray-500">Status</dt>
                            <dd class="mt-1">
                                <span
                                    class="inline-flex px-2 py-1 text-xs font-semibold rounded-full bg-{{ $payment->payment_status->color() }}-100 text-{{ $payment->payment_status->color() }}-800">
                                    {{ $payment->payment_status->label() }}
                                </span>
                            </dd>
                        </div>
                        <div>
                            <dt class="text-sm font-medium text-gray-500">Payment Date</dt>
                            <dd class="mt-1 text-sm text-gray-900">
                                {{ $payment->payment_date ? $payment->payment_date->format('M d, Y H:i') : '-' }}</dd>
                        </div>
                        @if ($payment->verified_at)
                            <div>
                                <dt class="text-sm font-medium text-gray-500">Verified At</dt>
                                <dd class="mt-1 text-sm text-gray-900">{{ $payment->verified_at->format('M d, Y H:i') }}
                                </dd>
                            </div>
                            <div>
                                <dt class="text-sm font-medium text-gray-500">Verified By</dt>
                                <dd class="mt-1 text-sm text-gray-900">{{ $payment->verifiedBy->name ?? 'System' }}
                                </dd>
                            </div>
                        @endif
                    </dl>
                </div>
            </div>

            <!-- Payment Proof -->
            @if ($payment->payment_proof)
                <div class="bg-white rounded-lg shadow">
                    <div class="px-6 py-4 border-b border-gray-200">
                        <h3 class="text-lg font-medium text-gray-900">Payment Proof</h3>
                    </div>
                    <div class="p-6">
                        <div class="max-w-md mx-auto">
                            <img src="{{ Storage::url($payment->payment_proof) }}" alt="Payment Proof"
                                class="w-full rounded-lg shadow-sm border border-gray-200">
                        </div>
                        <div class="mt-4 text-center">
                            <a href="{{ Storage::url($payment->payment_proof) }}" target="_blank"
                                class="text-amber-600 hover:text-amber-700 text-sm font-medium">
                                View Full Size →
                            </a>
                        </div>
                    </div>
                </div>
            @endif

            <!-- Order Items -->
            <div class="bg-white rounded-lg shadow">
                <div class="px-6 py-4 border-b border-gray-200">
                    <h3 class="text-lg font-medium text-gray-900">Order Items</h3>
                </div>
                <div class="p-6">
                    <div class="space-y-4">
                        @foreach ($payment->order->orderItems as $item)
                            <div class="flex items-center space-x-4">
                                <img src="{{ $item->songket->primary_image }}" alt="{{ $item->songket->name }}"
                                    class="w-12 h-12 object-cover rounded-lg">
                                <div class="flex-1">
                                    <h4 class="text-sm font-medium text-gray-900">{{ $item->songket->name }}</h4>
                                    <p class="text-xs text-gray-600">{{ $item->songket->category->name }}</p>
                                </div>
                                <div class="text-right">
                                    <div class="text-sm font-medium text-gray-900">{{ $item->formatted_total_price }}
                                    </div>
                                    <div class="text-xs text-gray-500">Qty: {{ $item->quantity }}</div>
                                </div>
                            </div>
                        @endforeach
                    </div>
                </div>
            </div>
        </div>

        <!-- Actions -->
        <div class="space-y-6">
            <!-- Payment Verification -->
            @if ($payment->payment_status === App\Enums\PaymentStatus::WAITING_VERIFICATION)
                <div class="bg-white rounded-lg shadow">
                    <div class="px-6 py-4 border-b border-gray-200">
                        <h3 class="text-lg font-medium text-gray-900">Payment Verification</h3>
                    </div>
                    <div class="p-6">
                        <form method="POST" action="{{ route('admin.payments.verify', $payment) }}">
                            @csrf
                            @method('PATCH')
                            <div class="space-y-4">
                                <div>
                                    <label class="block text-sm font-medium text-gray-700 mb-2">Action</label>
                                    <div class="space-y-2">
                                        <label class="flex items-center">
                                            <input type="radio" name="action" value="approve"
                                                class="text-green-600 focus:ring-green-500">
                                            <span class="ml-2 text-sm text-gray-900">Approve Payment</span>
                                        </label>
                                        <label class="flex items-center">
                                            <input type="radio" name="action" value="reject"
                                                class="text-red-600 focus:ring-red-500">
                                            <span class="ml-2 text-sm text-gray-900">Reject Payment</span>
                                        </label>
                                    </div>
                                </div>

                                <div>
                                    <label for="notes" class="block text-sm font-medium text-gray-700 mb-2">Notes
                                        (Optional)</label>
                                    <textarea name="notes" id="notes" rows="3"
                                        class="w-full px-3 py-2 border border-gray-300 rounded-lg focus:ring-2 focus:ring-amber-500 focus:border-transparent"
                                        placeholder="Add verification notes..."></textarea>
                                </div>

                                <button type="submit"
                                    class="w-full bg-amber-500 hover:bg-amber-600 text-white px-4 py-2 rounded-lg font-medium transition-colors">
                                    Submit Verification
                                </button>
                            </div>
                        </form>
                    </div>
                </div>
            @endif

            <!-- Order Information -->
            <div class="bg-white rounded-lg shadow">
                <div class="px-6 py-4 border-b border-gray-200">
                    <h3 class="text-lg font-medium text-gray-900">Order Information</h3>
                </div>
                <div class="p-6">
                    <dl class="space-y-3">
                        <div>
                            <dt class="text-sm font-medium text-gray-500">Order Number</dt>
                            <dd class="mt-1 text-sm text-gray-900">{{ $payment->order->order_number }}</dd>
                        </div>
                        <div>
                            <dt class="text-sm font-medium text-gray-500">Customer</dt>
                            <dd class="mt-1 text-sm text-gray-900">{{ $payment->order->customer_name }}</dd>
                        </div>
                        <div>
                            <dt class="text-sm font-medium text-gray-500">Email</dt>
                            <dd class="mt-1 text-sm text-gray-900">{{ $payment->order->customer_email }}</dd>
                        </div>
                        <div>
                            <dt class="text-sm font-medium text-gray-500">Phone</dt>
                            <dd class="mt-1 text-sm text-gray-900">{{ $payment->order->customer_phone }}</dd>
                        </div>
                        <div>
                            <dt class="text-sm font-medium text-gray-500">Order Status</dt>
                            <dd class="mt-1">
                                <span
                                    class="inline-flex px-2 py-1 text-xs font-semibold rounded-full bg-{{ $payment->order->status->color() }}-100 text-{{ $payment->order->status->color() }}-800">
                                    {{ $payment->order->status->label() }}
                                </span>
                            </dd>
                        </div>
                    </dl>

                    <div class="mt-4">
                        <a href="{{ route('admin.orders.show', $payment->order) }}"
                            class="text-amber-600 hover:text-amber-700 text-sm font-medium">
                            View Full Order →
                        </a>
                    </div>
                </div>
            </div>
        </div>
    </div>
</x-admin-layout>
