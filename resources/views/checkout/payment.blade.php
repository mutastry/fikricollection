<x-app-layout>
    <x-slot name="title">Payment - Order #{{ $order->order_number }}</x-slot>

    <div class="min-h-screen bg-gradient-to-br from-amber-50 via-orange-50 to-yellow-50">
        <!-- Progress Bar -->
        <div class="bg-white shadow-sm border-b border-gray-200">
            <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8 py-4">
                <div class="flex items-center justify-center space-x-8">
                    <div class="flex items-center">
                        <div
                            class="w-8 h-8 bg-green-500 text-white rounded-full flex items-center justify-center text-sm font-bold">
                            <x-icon name="heroicon-o-check" class="h-4 w-4" />
                        </div>
                        <span class="ml-2 text-sm font-medium text-green-600">Customer Info</span>
                    </div>
                    <div class="w-16 h-0.5 bg-green-500"></div>
                    <div class="flex items-center">
                        <div
                            class="w-8 h-8 bg-amber-500 text-white rounded-full flex items-center justify-center text-sm font-bold">
                            2</div>
                        <span class="ml-2 text-sm font-medium text-amber-600">Payment</span>
                    </div>
                    <div class="w-16 h-0.5 bg-gray-300"></div>
                    <div class="flex items-center">
                        <div
                            class="w-8 h-8 bg-gray-300 text-gray-600 rounded-full flex items-center justify-center text-sm font-bold">
                            3</div>
                        <span class="ml-2 text-sm font-medium text-gray-500">Confirmation</span>
                    </div>
                </div>
            </div>
        </div>

        <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8 py-8">
            <div class="mb-8">
                <h1 class="text-3xl md:text-4xl font-bold text-gray-900 font-serif mb-4">Payment</h1>
                <p class="text-lg text-gray-600">Choose your preferred payment method for Order
                    #{{ $order->order_number }}</p>
            </div>
            <x-session-alerts />

            <form method="POST" action="{{ route('checkout.payment.process', $order) }}" enctype="multipart/form-data"
                class="grid grid-cols-1 lg:grid-cols-3 gap-8" x-data="paymentForm()">
                @csrf

                <!-- Payment Methods -->
                <div class="lg:col-span-2 space-y-6">
                    <div class="bg-white rounded-2xl shadow-sm border border-gray-100 p-8">
                        <div class="flex items-center mb-6">
                            <div class="w-10 h-10 bg-amber-100 rounded-full flex items-center justify-center mr-3">
                                <x-icon name="heroicon-o-credit-card" class="h-5 w-5 text-amber-600" />
                            </div>
                            <h2 class="text-2xl font-bold text-gray-900">Select Payment Method</h2>
                        </div>

                        <div class="grid grid-cols-1 md:grid-cols-2 gap-4">
                            <!-- Bank Transfer -->
                            <label class="relative cursor-pointer">
                                <input type="radio" name="payment_method" value="bank_transfer"
                                    x-model="selectedMethod" class="sr-only">
                                <div class="border-2 rounded-xl p-6 transition-all duration-200"
                                    :class="selectedMethod === 'bank_transfer' ? 'border-amber-500 bg-amber-50' :
                                        'border-gray-200 hover:border-gray-300'">
                                    <div class="flex items-center justify-between mb-3">
                                        <div class="flex items-center">
                                            <div
                                                class="w-10 h-10 bg-blue-100 rounded-lg flex items-center justify-center mr-3">
                                                <x-icon name="heroicon-o-building-library"
                                                    class="h-5 w-5 text-blue-600" />
                                            </div>
                                            <h3 class="font-semibold text-gray-900">Bank Transfer</h3>
                                        </div>
                                        <div class="w-5 h-5 rounded-full border-2 flex items-center justify-center"
                                            :class="selectedMethod === 'bank_transfer' ? 'border-amber-500 bg-amber-500' :
                                                'border-gray-300'">
                                            <div class="w-2 h-2 bg-white rounded-full"
                                                x-show="selectedMethod === 'bank_transfer'"></div>
                                        </div>
                                    </div>
                                    <p class="text-sm text-gray-600">Transfer to our bank account and upload payment
                                        proof</p>
                                </div>
                            </label>

                            <!-- QRIS -->
                            <label class="relative cursor-pointer">
                                <input type="radio" name="payment_method" value="qris" x-model="selectedMethod"
                                    class="sr-only">
                                <div class="border-2 rounded-xl p-6 transition-all duration-200"
                                    :class="selectedMethod === 'qris' ? 'border-amber-500 bg-amber-50' :
                                        'border-gray-200 hover:border-gray-300'">
                                    <div class="flex items-center justify-between mb-3">
                                        <div class="flex items-center">
                                            <div
                                                class="w-10 h-10 bg-green-100 rounded-lg flex items-center justify-center mr-3">
                                                <x-icon name="heroicon-o-qr-code" class="h-5 w-5 text-green-600" />
                                            </div>
                                            <h3 class="font-semibold text-gray-900">QRIS</h3>
                                        </div>
                                        <div class="w-5 h-5 rounded-full border-2 flex items-center justify-center"
                                            :class="selectedMethod === 'qris' ? 'border-amber-500 bg-amber-500' :
                                                'border-gray-300'">
                                            <div class="w-2 h-2 bg-white rounded-full"
                                                x-show="selectedMethod === 'qris'"></div>
                                        </div>
                                    </div>
                                    <p class="text-sm text-gray-600">Scan QR code with your mobile banking app</p>
                                </div>
                            </label>

                            <!-- E-Wallet -->
                            <label class="relative cursor-pointer">
                                <input type="radio" name="payment_method" value="e_wallet" x-model="selectedMethod"
                                    class="sr-only">
                                <div class="border-2 rounded-xl p-6 transition-all duration-200"
                                    :class="selectedMethod === 'e_wallet' ? 'border-amber-500 bg-amber-50' :
                                        'border-gray-200 hover:border-gray-300'">
                                    <div class="flex items-center justify-between mb-3">
                                        <div class="flex items-center">
                                            <div
                                                class="w-10 h-10 bg-purple-100 rounded-lg flex items-center justify-center mr-3">
                                                <x-icon name="heroicon-o-device-phone-mobile"
                                                    class="h-5 w-5 text-purple-600" />
                                            </div>
                                            <h3 class="font-semibold text-gray-900">E-Wallet</h3>
                                        </div>
                                        <div class="w-5 h-5 rounded-full border-2 flex items-center justify-center"
                                            :class="selectedMethod === 'e_wallet' ? 'border-amber-500 bg-amber-500' :
                                                'border-gray-300'">
                                            <div class="w-2 h-2 bg-white rounded-full"
                                                x-show="selectedMethod === 'e_wallet'"></div>
                                        </div>
                                    </div>
                                    <p class="text-sm text-gray-600">Pay with GoPay, OVO, DANA, or ShopeePay</p>
                                </div>
                            </label>

                            <!-- Pay in Store -->
                            <label class="relative cursor-pointer">
                                <input type="radio" name="payment_method" value="pay_in_store"
                                    x-model="selectedMethod" class="sr-only">
                                <div class="border-2 rounded-xl p-6 transition-all duration-200"
                                    :class="selectedMethod === 'pay_in_store' ? 'border-amber-500 bg-amber-50' :
                                        'border-gray-200 hover:border-gray-300'">
                                    <div class="flex items-center justify-between mb-3">
                                        <div class="flex items-center">
                                            <div
                                                class="w-10 h-10 bg-orange-100 rounded-lg flex items-center justify-center mr-3">
                                                <x-icon name="heroicon-o-building-storefront"
                                                    class="h-5 w-5 text-orange-600" />
                                            </div>
                                            <h3 class="font-semibold text-gray-900">Pay in Store</h3>
                                        </div>
                                        <div class="w-5 h-5 rounded-full border-2 flex items-center justify-center"
                                            :class="selectedMethod === 'pay_in_store' ? 'border-amber-500 bg-amber-500' :
                                                'border-gray-300'">
                                            <div class="w-2 h-2 bg-white rounded-full"
                                                x-show="selectedMethod === 'pay_in_store'"></div>
                                        </div>
                                    </div>
                                    <p class="text-sm text-gray-600">Pay when you pick up your order at our store</p>
                                </div>
                            </label>
                        </div>

                        @error('payment_method')
                            <p class="mt-4 text-sm text-red-600 flex items-center">
                                <x-icon name="heroicon-o-exclamation-circle" class="h-4 w-4 mr-1" />
                                {{ $message }}
                            </p>
                        @enderror
                    </div>

                    <!-- Payment Instructions -->
                    <div x-show="selectedMethod" class="bg-white rounded-2xl shadow-sm border border-gray-100 p-8">
                        <div class="flex items-center mb-6">
                            <div class="w-10 h-10 bg-blue-100 rounded-full flex items-center justify-center mr-3">
                                <x-icon name="heroicon-o-information-circle" class="h-5 w-5 text-blue-600" />
                            </div>
                            <h2 class="text-2xl font-bold text-gray-900">Payment Instructions</h2>
                        </div>

                        <!-- Bank Transfer Instructions -->
                        <div x-show="selectedMethod === 'bank_transfer'" class="space-y-6">
                            <div class="bg-blue-50 border border-blue-200 rounded-xl p-6">
                                <h3 class="font-semibold text-blue-900 mb-4 flex items-center">
                                    <x-icon name="heroicon-o-building-library" class="h-5 w-5 mr-2" />
                                    Bank Transfer Details
                                </h3>
                                <div class="space-y-4">
                                    <div class="bg-white rounded-lg p-4 border border-blue-200">
                                        <div class="flex justify-between items-center mb-2">
                                            <span class="text-sm text-gray-600">Bank Name</span>
                                            <span class="font-semibold text-gray-900">Bank Mandiri</span>
                                        </div>
                                        <div class="flex justify-between items-center mb-2">
                                            <span class="text-sm text-gray-600">Account Number</span>
                                            <span class="font-mono font-semibold text-gray-900">1234567890</span>
                                        </div>
                                        <div class="flex justify-between items-center">
                                            <span class="text-sm text-gray-600">Account Name</span>
                                            <span class="font-semibold text-gray-900">Palembang Songket Store</span>
                                        </div>
                                    </div>
                                    <div class="bg-white rounded-lg p-4 border border-blue-200">
                                        <div class="flex justify-between items-center">
                                            <span class="text-sm text-gray-600">Transfer Amount</span>
                                            <span
                                                class="text-xl font-bold text-amber-600">{{ $order->formatted_total_amount }}</span>
                                        </div>
                                    </div>
                                </div>
                            </div>
                            <div class="bg-yellow-50 border border-yellow-200 rounded-xl p-4">
                                <h4 class="font-semibold text-yellow-900 mb-2 flex items-center">
                                    <x-icon name="heroicon-o-exclamation-triangle" class="h-4 w-4 mr-2" />
                                    Important Instructions
                                </h4>
                                <ul class="text-sm text-yellow-800 space-y-1">
                                    <li>• Transfer the exact amount: {{ $order->formatted_total_amount }}</li>
                                    <li>• Include your order number ({{ $order->order_number }}) in the transfer
                                        description</li>
                                    <li>• Upload a clear photo of your transfer receipt below</li>
                                    <li>• Payment verification takes 1-2 business hours</li>
                                </ul>
                            </div>
                        </div>

                        <!-- QRIS Instructions -->
                        <div x-show="selectedMethod === 'qris'" class="space-y-6">
                            <div class="bg-green-50 border border-green-200 rounded-xl p-6">
                                <h3 class="font-semibold text-green-900 mb-4 flex items-center">
                                    <x-icon name="heroicon-o-qr-code" class="h-5 w-5 mr-2" />
                                    QRIS Payment
                                </h3>
                                <div class="text-center">
                                    <div
                                        class="w-48 h-48 bg-white border-2 border-green-300 rounded-xl mx-auto mb-4 flex items-center justify-center">
                                        <div class="text-center">
                                            <x-icon name="heroicon-o-qr-code"
                                                class="h-16 w-16 text-green-600 mx-auto mb-2" />
                                            <p class="text-sm text-gray-600">QR Code will be displayed here</p>
                                        </div>
                                    </div>
                                    <div class="bg-white rounded-lg p-4 border border-green-200">
                                        <div class="flex justify-between items-center">
                                            <span class="text-sm text-gray-600">Amount to Pay</span>
                                            <span
                                                class="text-xl font-bold text-amber-600">{{ $order->formatted_total_amount }}</span>
                                        </div>
                                    </div>
                                </div>
                            </div>
                            <div class="bg-blue-50 border border-blue-200 rounded-xl p-4">
                                <h4 class="font-semibold text-blue-900 mb-2 flex items-center">
                                    <x-icon name="heroicon-o-device-phone-mobile" class="h-4 w-4 mr-2" />
                                    How to Pay with QRIS
                                </h4>
                                <ol class="text-sm text-blue-800 space-y-1 list-decimal list-inside">
                                    <li>Open your mobile banking app or e-wallet</li>
                                    <li>Select "Scan QR" or "QRIS" option</li>
                                    <li>Scan the QR code above</li>
                                    <li>Confirm the payment amount</li>
                                    <li>Complete the payment and take a screenshot</li>
                                    <li>Upload the payment screenshot below</li>
                                </ol>
                            </div>
                        </div>

                        <!-- E-Wallet Instructions -->
                        <div x-show="selectedMethod === 'e_wallet'" class="space-y-6">
                            <div class="bg-purple-50 border border-purple-200 rounded-xl p-6">
                                <h3 class="font-semibold text-purple-900 mb-4 flex items-center">
                                    <x-icon name="heroicon-o-device-phone-mobile" class="h-5 w-5 mr-2" />
                                    E-Wallet Payment Options
                                </h3>
                                <div class="grid grid-cols-2 gap-4">
                                    <div class="bg-white rounded-lg p-4 border border-purple-200 text-center">
                                        <div
                                            class="w-12 h-12 bg-green-100 rounded-lg mx-auto mb-2 flex items-center justify-center">
                                            <span class="font-bold text-green-600">GO</span>
                                        </div>
                                        <p class="font-semibold text-gray-900">GoPay</p>
                                        <p class="text-xs text-gray-600">0812-3456-7890</p>
                                    </div>
                                    <div class="bg-white rounded-lg p-4 border border-purple-200 text-center">
                                        <div
                                            class="w-12 h-12 bg-purple-100 rounded-lg mx-auto mb-2 flex items-center justify-center">
                                            <span class="font-bold text-purple-600">OVO</span>
                                        </div>
                                        <p class="font-semibold text-gray-900">OVO</p>
                                        <p class="text-xs text-gray-600">0812-3456-7890</p>
                                    </div>
                                    <div class="bg-white rounded-lg p-4 border border-purple-200 text-center">
                                        <div
                                            class="w-12 h-12 bg-blue-100 rounded-lg mx-auto mb-2 flex items-center justify-center">
                                            <span class="font-bold text-blue-600">DANA</span>
                                        </div>
                                        <p class="font-semibold text-gray-900">DANA</p>
                                        <p class="text-xs text-gray-600">0812-3456-7890</p>
                                    </div>
                                    <div class="bg-white rounded-lg p-4 border border-purple-200 text-center">
                                        <div
                                            class="w-12 h-12 bg-orange-100 rounded-lg mx-auto mb-2 flex items-center justify-center">
                                            <span class="font-bold text-orange-600">SP</span>
                                        </div>
                                        <p class="font-semibold text-gray-900">ShopeePay</p>
                                        <p class="text-xs text-gray-600">0812-3456-7890</p>
                                    </div>
                                </div>
                                <div class="mt-4 bg-white rounded-lg p-4 border border-purple-200">
                                    <div class="flex justify-between items-center">
                                        <span class="text-sm text-gray-600">Amount to Transfer</span>
                                        <span
                                            class="text-xl font-bold text-amber-600">{{ $order->formatted_total_amount }}</span>
                                    </div>
                                </div>
                            </div>
                            <div class="bg-yellow-50 border border-yellow-200 rounded-xl p-4">
                                <h4 class="font-semibold text-yellow-900 mb-2 flex items-center">
                                    <x-icon name="heroicon-o-exclamation-triangle" class="h-4 w-4 mr-2" />
                                    Payment Instructions
                                </h4>
                                <ul class="text-sm text-yellow-800 space-y-1">
                                    <li>• Choose your preferred e-wallet from the options above</li>
                                    <li>• Transfer exactly {{ $order->formatted_total_amount }} to the specified number
                                    </li>
                                    <li>• Include "Order {{ $order->order_number }}" in the transfer note</li>
                                    <li>• Take a screenshot of the successful transfer</li>
                                    <li>• Upload the screenshot below for verification</li>
                                </ul>
                            </div>
                        </div>

                        <!-- Pay in Store Instructions -->
                        <div x-show="selectedMethod === 'pay_in_store'" class="space-y-6">
                            <div class="bg-orange-50 border border-orange-200 rounded-xl p-6">
                                <h3 class="font-semibold text-orange-900 mb-4 flex items-center">
                                    <x-icon name="heroicon-o-building-storefront" class="h-5 w-5 mr-2" />
                                    Pay at Store
                                </h3>
                                <div class="bg-white rounded-lg p-4 border border-orange-200">
                                    <div class="grid grid-cols-1 md:grid-cols-2 gap-4">
                                        <div>
                                            <h4 class="font-semibold text-gray-900 mb-2 flex items-center">
                                                <x-icon name="heroicon-o-map-pin"
                                                    class="h-4 w-4 mr-2 text-orange-600" />
                                                Store Address
                                            </h4>
                                            <p class="text-sm text-gray-600">
                                                Jl. Sudirman No. 123<br>
                                                Palembang, South Sumatra 30126
                                            </p>
                                        </div>
                                        <div>
                                            <h4 class="font-semibold text-gray-900 mb-2 flex items-center">
                                                <x-icon name="heroicon-o-clock"
                                                    class="h-4 w-4 mr-2 text-orange-600" />
                                                Store Hours
                                            </h4>
                                            <p class="text-sm text-gray-600">
                                                Mon - Sat: 9:00 AM - 6:00 PM<br>
                                                Sunday: 10:00 AM - 4:00 PM
                                            </p>
                                        </div>
                                    </div>
                                    <div class="mt-4 pt-4 border-t border-orange-200">
                                        <div class="flex justify-between items-center">
                                            <span class="text-sm text-gray-600">Amount to Pay</span>
                                            <span
                                                class="text-xl font-bold text-amber-600">{{ $order->formatted_total_amount }}</span>
                                        </div>
                                    </div>
                                </div>
                            </div>
                            <div class="bg-green-50 border border-green-200 rounded-xl p-4">
                                <h4 class="font-semibold text-green-900 mb-2 flex items-center">
                                    <x-icon name="heroicon-o-check-circle" class="h-4 w-4 mr-2" />
                                    What to Bring
                                </h4>
                                <ul class="text-sm text-green-800 space-y-1">
                                    <li>• Your order number: <strong>{{ $order->order_number }}</strong></li>
                                    <li>• Valid ID (KTP, SIM, or Passport)</li>
                                    <li>• Cash or debit/credit card for payment</li>
                                    <li>• This confirmation page (printed or on your phone)</li>
                                </ul>
                            </div>
                        </div>
                    </div>

                    <!-- Payment Proof Upload -->
                    <div x-show="selectedMethod && selectedMethod !== 'pay_in_store'"
                        class="bg-white rounded-2xl shadow-sm border border-gray-100 p-8">
                        <div class="flex items-center mb-6">
                            <div class="w-10 h-10 bg-green-100 rounded-full flex items-center justify-center mr-3">
                                <x-icon name="heroicon-o-photo" class="h-5 w-5 text-green-600" />
                            </div>
                            <h2 class="text-2xl font-bold text-gray-900">Upload Payment Proof</h2>
                        </div>

                        {{-- <div class="border-2 border-dashed border-gray-300 rounded-xl p-8 text-center">
                            <input type="file" name="payment_proof" accept="image/*" class="hidden"
                                x-ref="fileInput" @change="handleFileSelect">
                            <div class="space-y-4">
                                <div
                                    class="w-16 h-16 bg-gray-100 rounded-full flex items-center justify-center mx-auto">
                                    <x-icon name="heroicon-o-cloud-arrow-up" class="h-8 w-8 text-gray-400" />
                                </div>
                                <div>
                                    <button type="button" @click="$refs.fileInput.click()"
                                        class="bg-amber-500 hover:bg-amber-600 text-white px-6 py-2 rounded-lg font-medium transition-colors">
                                        Choose File
                                    </button>
                                    <p class="text-sm text-gray-500 mt-2">Upload screenshot or photo of your payment
                                    </p>
                                    <p class="text-xs text-gray-400">PNG, JPG, GIF up to 2MB</p>
                                </div>
                                <div x-show="selectedFile" class="text-sm text-gray-600">
                                    Selected: <span x-text="selectedFile"></span>
                                </div>
                            </div>
                        </div> --}}
                        <x-image-upload name="payment_proof" label="Payment Proof" :multiple="false" :max-files="1"
                            :max-size="2048" accept="image/*" :required="false"
                            help="Upload your payment receipt, bank transfer confirmation, or e-wallet screenshot. Accepted formats: JPG, PNG(max 2MB)" />

                    </div>
                </div>

                <!-- Order Summary -->
                <div class="lg:col-span-1">
                    <div class="sticky top-8">
                        <div class="bg-white rounded-2xl shadow-lg border border-gray-100 overflow-hidden">
                            <!-- Header -->
                            <div class="bg-gradient-to-r from-amber-500 to-orange-500 p-6 text-white">
                                <h2 class="text-xl font-bold flex items-center">
                                    <x-icon name="heroicon-o-document-text" class="h-5 w-5 mr-2" />
                                    Order #{{ $order->order_number }}
                                </h2>
                                <p class="text-amber-100 text-sm">{{ $order->orderItems->count() }} items</p>
                            </div>

                            <!-- Content -->
                            <div class="p-6">
                                <div class="space-y-4 mb-6">
                                    <div class="flex justify-between items-center">
                                        <span class="text-gray-600">Subtotal</span>
                                        <span
                                            class="font-semibold text-gray-900">{{ $order->formatted_total_amount }}</span>
                                    </div>
                                    <div class="flex justify-between items-center">
                                        <span class="text-gray-600">Pickup</span>
                                        <span class="font-semibold text-green-600">Free</span>
                                    </div>
                                    <div class="border-t border-gray-200 pt-4">
                                        <div class="flex justify-between items-center">
                                            <span class="text-xl font-bold text-gray-900">Total</span>
                                            <span
                                                class="text-2xl font-bold text-amber-600">{{ $order->formatted_total_amount }}</span>
                                        </div>
                                    </div>
                                </div>

                                <button type="submit" :disabled="!selectedMethod || submitting"
                                    class="w-full bg-gradient-to-r from-amber-500 to-orange-500 hover:from-amber-600 hover:to-orange-600 disabled:from-gray-400 disabled:to-gray-500 text-white py-4 rounded-xl font-bold text-lg transition-all duration-300 shadow-lg hover:shadow-xl transform hover:-translate-y-0.5 disabled:transform-none disabled:cursor-not-allowed">
                                    <div class="flex items-center justify-center">
                                        <div x-show="submitting" class="animate-spin -ml-1 mr-3 h-5 w-5 text-white">
                                            <svg class="h-5 w-5" xmlns="http://www.w3.org/2000/svg" fill="none"
                                                viewBox="0 0 24 24">
                                                <circle class="opacity-25" cx="12" cy="12" r="10"
                                                    stroke="currentColor" stroke-width="4"></circle>
                                                <path class="opacity-75" fill="currentColor"
                                                    d="M4 12a8 8 0 018-8V0C5.373 0 0 5.373 0 12h4zm2 5.291A7.962 7.962 0 014 12H0c0 3.042 1.135 5.824 3 7.938l3-2.647z">
                                                </path>
                                            </svg>
                                        </div>
                                        <x-icon name="heroicon-o-check-circle" class="h-5 w-5 mr-2"
                                            x-show="!submitting" />
                                        <span x-text="submitting ? 'Processing...' : 'Complete Payment'"></span>
                                    </div>
                                </button>

                                <!-- Customer Info -->
                                <div class="mt-6 pt-6 border-t border-gray-200">
                                    <h3 class="font-semibold text-gray-900 mb-3 flex items-center">
                                        <x-icon name="heroicon-o-user" class="h-4 w-4 mr-2 text-amber-600" />
                                        Customer Details
                                    </h3>
                                    <div class="space-y-2 text-sm text-gray-600">
                                        <p class="flex items-center">
                                            <x-icon name="heroicon-o-user-circle" class="h-3 w-3 mr-2" />
                                            {{ $order->customer_name }}
                                        </p>
                                        <p class="flex items-center">
                                            <x-icon name="heroicon-o-envelope" class="h-3 w-3 mr-2" />
                                            {{ $order->customer_email }}
                                        </p>
                                        <p class="flex items-center">
                                            <x-icon name="heroicon-o-phone" class="h-3 w-3 mr-2" />
                                            {{ $order->customer_phone }}
                                        </p>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </form>
        </div>
    </div>

    <script>
        function paymentForm() {
            return {
                selectedMethod: '',
                selectedFile: '',
                submitting: false,

                init() {
                    this.$el.addEventListener('submit', (e) => {
                        this.submitting = true;
                    });
                }
            }
        }
    </script>
</x-app-layout>
