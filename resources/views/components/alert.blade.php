@props([
    'type' => 'info',
    'title' => null,
    'dismissible' => true,
    'icon' => true,
])

@php
    $alertClasses = [
        'success' => 'bg-green-50 border-green-200 text-green-800',
        'error' => 'bg-red-50 border-red-200 text-red-800',
        'warning' => 'bg-yellow-50 border-yellow-200 text-yellow-800',
        'info' => 'bg-blue-50 border-blue-200 text-blue-800',
    ];

    $iconClasses = [
        'success' => 'text-green-400',
        'error' => 'text-red-400',
        'warning' => 'text-yellow-400',
        'info' => 'text-blue-400',
    ];

    $iconNames = [
        'success' => 'heroicon-o-check-circle',
        'error' => 'heroicon-o-x-circle',
        'warning' => 'heroicon-o-exclamation-triangle',
        'info' => 'heroicon-o-information-circle',
    ];

    $currentAlertClass = $alertClasses[$type] ?? $alertClasses['info'];
    $currentIconClass = $iconClasses[$type] ?? $iconClasses['info'];
    $currentIconName = $iconNames[$type] ?? $iconNames['info'];
@endphp

<div {{ $attributes->merge(['class' => "rounded-lg border p-4 {$currentAlertClass}"]) }} x-data="{ show: true }"
    x-show="show" x-transition:enter="transition ease-out duration-300"
    x-transition:enter-start="opacity-0 transform scale-95" x-transition:enter-end="opacity-100 transform scale-100"
    x-transition:leave="transition ease-in duration-200" x-transition:leave-start="opacity-100 transform scale-100"
    x-transition:leave-end="opacity-0 transform scale-95">

    <div class="flex items-start">
        @if ($icon)
            <div class="flex-shrink-0">
                <x-icon name="{{ $currentIconName }}" class="h-5 w-5 {{ $currentIconClass }}" />
            </div>
        @endif

        <div class="ml-3 flex-1">
            @if ($title)
                <h3 class="text-sm font-medium mb-1">
                    {{ $title }}
                </h3>
            @endif

            <div class="text-sm">
                {{ $slot }}
            </div>
        </div>

        @if ($dismissible)
            <div class="ml-auto pl-3">
                <div class="-mx-1.5 -my-1.5">
                    <button type="button"
                        class="inline-flex rounded-md p-1.5 hover:bg-black hover:bg-opacity-10 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-offset-transparent focus:ring-gray-600"
                        x-on:click="show = false">
                        <span class="sr-only">Dismiss</span>
                        <x-icon name="heroicon-o-x-mark" class="h-5 w-5" />
                    </button>
                </div>
            </div>
        @endif
    </div>
</div>
