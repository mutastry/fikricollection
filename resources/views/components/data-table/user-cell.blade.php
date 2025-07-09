@props(['item', 'column'])

@php
    $user = data_get($item, $column['key']);
@endphp

<div>
    <div class="text-sm font-medium text-gray-900">{{ $user->name ?? data_get($item, $column['name_key']) }}</div>
    <div class="text-sm text-gray-500">{{ $user->email ?? data_get($item, $column['email_key']) }}</div>
</div>
