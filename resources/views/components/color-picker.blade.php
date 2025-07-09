@props([
    'name' => 'color',
    'label' => 'Color',
    'value' => '#000000',
    'required' => false,
    'disabled' => false,
    'colors' => [
        '#FF0000',
        '#FF4500',
        '#FF8C00',
        '#FFD700',
        '#FFFF00',
        '#ADFF2F',
        '#00FF00',
        '#00FA9A',
        '#00FFFF',
        '#00BFFF',
        '#0000FF',
        '#4169E1',
        '#8A2BE2',
        '#9400D3',
        '#FF00FF',
        '#FF1493',
        '#DC143C',
        '#B22222',
        '#8B0000',
        '#800000',
        '#FF6347',
        '#FF7F50',
        '#FFA500',
        '#F0E68C',
        '#BDB76B',
        '#9ACD32',
        '#32CD32',
        '#228B22',
        '#008000',
        '#006400',
        '#00FF7F',
        '#00CED1',
        '#20B2AA',
        '#008B8B',
        '#5F9EA0',
        '#4682B4',
        '#1E90FF',
        '#6495ED',
        '#191970',
        '#000080',
        '#4B0082',
        '#483D8B',
        '#6A5ACD',
        '#7B68EE',
        '#9370DB',
        '#BA55D3',
        '#DA70D6',
        '#EE82EE',
        '#DDA0DD',
        '#D8BFD8',
        '#FFB6C1',
        '#FFC0CB',
        '#F5DEB3',
        '#F4A460',
        '#D2691E',
        '#A0522D',
        '#8B4513',
        '#654321',
        '#708090',
        '#2F4F4F',
        '#000000',
        '#696969',
        '#808080',
        '#A9A9A9',
        '#C0C0C0',
        '#D3D3D3',
        '#DCDCDC',
        '#F5F5F5',
        '#FFFFFF',
    ],
    'allowCustom' => true,
    'help' => null,
])

@php
    $id = $name . '_' . uniqid();
@endphp

<div x-data="colorPicker({
    name: '{{ $name }}',
    value: '{{ $value }}',
    colors: {{ json_encode($colors) }},
    allowCustom: {{ $allowCustom ? 'true' : 'false' }}
})" class="space-y-3">

    @if ($label)
        <x-input-label :for="$id" :value="$label" :required="$required" />
    @endif

    <!-- Color Preview -->
    <div class="flex items-center space-x-3">
        <div class="w-12 h-12 rounded-lg border-2 border-gray-300 shadow-sm"
            :style="`background-color: ${selectedColor}`" :class="{ 'opacity-50': {{ $disabled ? 'true' : 'false' }} }">
        </div>
        <div class="flex-1">
            <div class="text-sm font-medium text-gray-700" x-text="selectedColor.toUpperCase()"></div>
            <div class="text-xs text-gray-500">Selected Color</div>
        </div>
    </div>

    <!-- Predefined Colors Grid -->
    <div class="space-y-2">
        <h4 class="text-sm font-medium text-gray-700">Predefined Colors</h4>
        <div class="grid grid-cols-8 sm:grid-cols-12 md:grid-cols-16 gap-2">
            <template x-for="(color, index) in colors" :key="'color-' + index">
                <button type="button" @click="selectColor(color)" :disabled="{{ $disabled ? 'true' : 'false' }}"
                    class="w-8 h-8 rounded-md border-2 transition-all duration-200 hover:scale-110 focus:outline-none focus:ring-2 focus:ring-amber-500 focus:ring-offset-1"
                    :style="`background-color: ${color}`"
                    :class="{
                        'border-amber-500 ring-2 ring-amber-500 ring-offset-1': selectedColor.toLowerCase() === color
                            .toLowerCase(),
                        'border-gray-300': selectedColor.toLowerCase() !== color.toLowerCase(),
                        'opacity-50 cursor-not-allowed': {{ $disabled ? 'true' : 'false' }},
                        'cursor-pointer': {{ $disabled ? 'false' : 'true' }}
                    }"
                    :title="color">
                </button>
            </template>
        </div>
    </div>

    @if ($allowCustom)
        <!-- Custom Color Section -->
        <div class="space-y-3 pt-2 border-t border-gray-200">
            <h4 class="text-sm font-medium text-gray-700">Custom Color</h4>

            <div class="flex items-center space-x-3">
                <!-- HTML5 Color Picker -->
                <div class="relative">
                    <input type="color" :value="selectedColor" @input="selectColor($event.target.value)"
                        :disabled="{{ $disabled ? 'true' : 'false' }}"
                        class="w-12 h-10 rounded-md border border-gray-300 cursor-pointer disabled:opacity-50 disabled:cursor-not-allowed"
                        title="Choose custom color">
                </div>

                <!-- Hex Input -->
                <div class="flex-1">
                    <div class="relative">
                        <span class="absolute left-3 top-1/2 transform -translate-y-1/2 text-gray-500 text-sm">#</span>
                        <input type="text" x-model="hexInput" @input="handleHexInput($event.target.value)"
                            :disabled="{{ $disabled ? 'true' : 'false' }}" placeholder="000000" maxlength="6"
                            class="w-full pl-8 pr-3 py-2 border border-gray-300 rounded-md text-sm focus:ring-amber-500 focus:border-amber-500 disabled:opacity-50 disabled:cursor-not-allowed"
                            :class="{ 'border-red-300 focus:border-red-500 focus:ring-red-500': hexError }">
                    </div>
                    <div x-show="hexError" class="mt-1 text-xs text-red-600" x-text="hexError"></div>
                </div>
            </div>
        </div>
    @endif

    <!-- Hidden Input -->
    <input type="hidden" :name="name" :value="selectedColor"
        :required="{{ $required ? 'true' : 'false' }}">

    @if ($help)
        <p class="text-sm text-gray-500">{{ $help }}</p>
    @endif

    @error($name)
        <p class="text-sm text-red-600">{{ $message }}</p>
    @enderror
</div>

<script>
    function colorPicker(config) {
        return {
            selectedColor: config.value || '#000000',
            hexInput: '',
            hexError: '',
            name: config.name,
            colors: config.colors,
            allowCustom: config.allowCustom,

            init() {
                this.updateHexInput();
            },

            selectColor(color) {
                this.selectedColor = color.toUpperCase();
                this.updateHexInput();
                this.clearHexError();
            },

            handleHexInput(value) {
                // Remove # if user types it
                value = value.replace('#', '');

                // Validate hex format
                if (value.length === 0) {
                    this.clearHexError();
                    return;
                }

                if (!/^[0-9A-Fa-f]{1,6}$/.test(value)) {
                    this.hexError = 'Invalid hex color format';
                    return;
                }

                this.clearHexError();

                // If valid 6-character hex, update selected color
                if (value.length === 6) {
                    this.selectedColor = '#' + value.toUpperCase();
                }
            },

            updateHexInput() {
                this.hexInput = this.selectedColor.replace('#', '');
            },

            clearHexError() {
                this.hexError = '';
            }
        };
    }
</script>

<style>
    /* Custom styles for color picker */
    input[type="color"] {
        -webkit-appearance: none;
        -moz-appearance: none;
        appearance: none;
        background-color: transparent;
        border: none;
        cursor: pointer;
    }

    input[type="color"]::-webkit-color-swatch-wrapper {
        padding: 0;
        border: none;
        border-radius: 6px;
    }

    input[type="color"]::-webkit-color-swatch {
        border: 1px solid #d1d5db;
        border-radius: 6px;
    }

    input[type="color"]::-moz-color-swatch {
        border: 1px solid #d1d5db;
        border-radius: 6px;
    }
</style>
