@props(['item', 'column'])

@php
    $images = data_get($item, $column['key']);
    $firstImage = is_array($images) ? $images[0] ?? null : $images;
@endphp

@if ($firstImage)
    <div class="flex items-center">
        <img src="{{ $firstImage }}" alt="{{ data_get($item, 'name', 'Image') }}"
            class="w-10 h-10 rounded-lg object-cover">
        @if (is_array($images) && count($images) > 1)
            <span class="ml-2 text-xs text-gray-500">+{{ count($images) - 1 }}</span>
        @endif
    </div>
@else
    <div class="w-10 h-10 bg-gray-200 rounded-lg flex items-center justify-center">
        <x-heroicon-o-photo class="w-5 h-5 text-gray-400" />
    </div>
@endif
