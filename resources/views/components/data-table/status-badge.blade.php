@props(['item', 'column'])

@php
    $status = data_get($item, $column['key']);
    $colorMap = $column['status_colors'] ?? [];
    $labelMap = $column['status_labels'] ?? [];

    $color = $colorMap[$status->value ?? $status] ?? 'gray';
    $label = $labelMap[$status->value ?? $status] ?? ($status->label ?? $status);
@endphp

<span
    class="inline-flex px-2 py-1 text-xs font-semibold rounded-full bg-{{ $color }}-100 text-{{ $color }}-800">
    {{ $label->label() }}
</span>
