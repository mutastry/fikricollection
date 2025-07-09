@props([
    'title' => '',
    'data' => collect(),
    'columns' => [],
    'searchable' => true,
    'filterable' => true,
    'exportable' => true,
    'createRoute' => null,
    'createLabel' => 'Tambah Baru',
    'exportRoute' => null,
    'filters' => [],
    'searchPlaceholder' => 'Cari...',
    'emptyMessage' => 'Tidak ada data ditemukan',
    'actions' => [],
])

<div class="space-y-6">
    <!-- Header -->
    <div class="flex flex-col sm:flex-row sm:items-center sm:justify-between">
        <h2 class="text-2xl font-bold text-gray-900 mb-4 sm:mb-0">{{ $title }}</h2>

        <div class="flex flex-col sm:flex-row gap-3">
            @if ($exportable && $exportRoute)
                <a href="{{ $exportRoute }}"
                    class="inline-flex items-center px-4 py-2 bg-green-600 hover:bg-green-700 text-white text-sm font-medium rounded-lg transition-colors">
                    <x-heroicon-o-arrow-down-tray class="w-4 h-4 mr-2" />
                    Export Data
                </a>
            @endif

            @if ($createRoute)
                <a href="{{ $createRoute }}"
                    class="inline-flex items-center px-4 py-2 bg-amber-500 hover:bg-amber-600 text-white text-sm font-medium rounded-lg transition-colors">
                    <x-heroicon-o-plus class="w-4 h-4 mr-2" />
                    {{ $createLabel }}
                </a>
            @endif
        </div>
    </div>

    <!-- Filters -->
    @if ($searchable || $filterable)
        <div class="bg-white rounded-lg shadow">
            <div class="p-6">
                <form method="GET" class="grid grid-cols-1 md:grid-cols-4 gap-4">
                    @if ($searchable)
                        <div>
                            <label for="search" class="block text-sm font-medium text-gray-700 mb-1">Pencarian</label>
                            <input type="text" name="search" id="search" value="{{ request('search') }}"
                                placeholder="{{ $searchPlaceholder }}"
                                class="w-full px-3 py-2 border border-gray-300 rounded-lg focus:ring-2 focus:ring-amber-500 focus:border-transparent">
                        </div>
                    @endif

                    @foreach ($filters as $filter)
                        <div>
                            <label for="{{ $filter['name'] }}" class="block text-sm font-medium text-gray-700 mb-1">
                                {{ $filter['label'] }}
                            </label>

                            @if ($filter['type'] === 'select')
                                <select name="{{ $filter['name'] }}" id="{{ $filter['name'] }}"
                                    class="w-full px-3 py-2 border border-gray-300 rounded-lg focus:ring-2 focus:ring-amber-500 focus:border-transparent">
                                    <option value="">{{ $filter['placeholder'] ?? 'Semua' }}</option>
                                    @foreach ($filter['options'] as $value => $label)
                                        <option value="{{ $value }}"
                                            {{ request($filter['name']) === $value ? 'selected' : '' }}>
                                            {{ $label }}
                                        </option>
                                    @endforeach
                                </select>
                            @elseif($filter['type'] === 'date')
                                <input type="date" name="{{ $filter['name'] }}" id="{{ $filter['name'] }}"
                                    value="{{ request($filter['name']) }}"
                                    class="w-full px-3 py-2 border border-gray-300 rounded-lg focus:ring-2 focus:ring-amber-500 focus:border-transparent">
                            @endif
                        </div>
                    @endforeach

                    @if ($searchable || $filterable)
                        <div class="flex items-end">
                            <button type="submit"
                                class="w-full bg-amber-500 hover:bg-amber-600 text-white px-4 py-2 rounded-lg font-medium transition-colors">
                                <x-heroicon-o-magnifying-glass class="w-4 h-4 mr-2 inline" />
                                Filter
                            </button>
                        </div>
                    @endif
                </form>
            </div>
        </div>
    @endif

    <!-- Data Table -->
    <div class="bg-white rounded-lg shadow overflow-hidden">
        <div class="overflow-x-auto">
            <table class="min-w-full divide-y divide-gray-200">
                <thead class="bg-gray-50">
                    <tr>
                        @foreach ($columns as $column)
                            <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">
                                {{ $column['label'] }}
                            </th>
                        @endforeach

                        @if (!empty($actions))
                            <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">
                                Aksi
                            </th>
                        @endif
                    </tr>
                </thead>
                <tbody class="bg-white divide-y divide-gray-200">
                    @forelse($data as $item)
                        <tr class="hover:bg-gray-50">
                            @foreach ($columns as $column)
                                <td class="px-6 py-4 {{ $column['nowrap'] ?? true ? 'whitespace-nowrap' : '' }}">
                                    @if (isset($column['component']))
                                        <x-dynamic-component :component="$column['component']" :item="$item" :column="$column" />
                                    @else
                                        <div class="text-sm {{ $column['class'] ?? 'text-gray-900' }}">
                                            @if (isset($column['format']))
                                                @if ($column['format'] === 'currency')
                                                    {{ 'Rp ' . number_format(data_get($item, $column['key']), 0, ',', '.') }}
                                                @elseif($column['format'] === 'date')
                                                    {{ data_get($item, $column['key']) ? \Carbon\Carbon::parse(data_get($item, $column['key']))->format('d M Y') : '-' }}
                                                @elseif($column['format'] === 'datetime')
                                                    {{ data_get($item, $column['key']) ? \Carbon\Carbon::parse(data_get($item, $column['key']))->format('d M Y H:i') : '-' }}
                                                @elseif($column['format'] === 'boolean')
                                                    <span
                                                        class="inline-flex px-2 py-1 text-xs font-semibold rounded-full {{ data_get($item, $column['key']) ? 'bg-green-100 text-green-800' : 'bg-red-100 text-red-800' }}">
                                                        {{ data_get($item, $column['key']) ? 'Ya' : 'Tidak' }}
                                                    </span>
                                                @elseif($column['format'] === 'badge')
                                                    @php
                                                        $value = data_get($item, $column['key']);
                                                        $badgeClass =
                                                            $column['badge_colors'][$value] ??
                                                            'bg-gray-100 text-gray-800';
                                                    @endphp
                                                    <span
                                                        class="inline-flex px-2 py-1 text-xs font-semibold rounded-full {{ $badgeClass }}">
                                                        {{ $column['badge_labels'][$value] ?? $value }}
                                                    </span>
                                                @else
                                                    {{ data_get($item, $column['key']) }}
                                                @endif
                                            @else
                                                {{ data_get($item, $column['key']) }}
                                            @endif
                                        </div>

                                        @if (isset($column['subtitle']))
                                            <div class="text-sm text-gray-500">
                                                {{ data_get($item, $column['subtitle']) }}
                                            </div>
                                        @endif
                                    @endif
                                </td>
                            @endforeach

                            @if (!empty($actions))
                                <td class="px-6 py-4 whitespace-nowrap text-sm font-medium">
                                    <div class="flex items-center space-x-3">
                                        @foreach ($actions as $action)
                                            @if (!isset($action['condition']) || $action['condition']($item))
                                                @if ($action['type'] === 'link')
                                                    <a href="{{ $action['url']($item) }}"
                                                        class="text-{{ $action['color'] ?? 'amber' }}-600 hover:text-{{ $action['color'] ?? 'amber' }}-900 transition-colors"
                                                        @if (isset($action['tooltip'])) title="{{ $action['tooltip'] }}" @endif>
                                                        @if (isset($action['icon']))
                                                            <x-dynamic-component :component="$action['icon']" class="w-4 h-4" />
                                                        @else
                                                            {{ $action['label'] }}
                                                        @endif
                                                    </a>
                                                @elseif($action['type'] === 'form')
                                                    <form method="POST" action="{{ $action['url']($item) }}"
                                                        class="inline">
                                                        @csrf
                                                        @if ($action['method'] !== 'POST')
                                                            @method($action['method'])
                                                        @endif
                                                        <button type="submit"
                                                            class="text-{{ $action['color'] ?? 'red' }}-600 hover:text-{{ $action['color'] ?? 'red' }}-900 transition-colors"
                                                            @if (isset($action['confirm'])) onclick="return confirm('{{ $action['confirm'] }}')" @endif
                                                            @if (isset($action['tooltip'])) title="{{ $action['tooltip'] }}" @endif>
                                                            @if (isset($action['icon']))
                                                                <x-dynamic-component :component="$action['icon']"
                                                                    class="w-4 h-4" />
                                                            @else
                                                                {{ $action['label'] }}
                                                            @endif
                                                        </button>
                                                    </form>
                                                @endif
                                            @endif
                                        @endforeach
                                    </div>
                                </td>
                            @endif
                        </tr>
                    @empty
                        <tr>
                            <td colspan="{{ count($columns) + (!empty($actions) ? 1 : 0) }}"
                                class="px-6 py-12 text-center">
                                <div class="flex flex-col items-center">
                                    <x-heroicon-o-inbox class="w-12 h-12 text-gray-400 mb-4" />
                                    <p class="text-gray-500 text-lg font-medium">{{ $emptyMessage }}</p>
                                    <p class="text-gray-400 text-sm mt-1">Coba ubah filter pencarian atau tambah data
                                        baru</p>
                                </div>
                            </td>
                        </tr>
                    @endforelse
                </tbody>
            </table>
        </div>

        <!-- Pagination -->
        @if (method_exists($data, 'hasPages') && $data->hasPages())
            <div class="px-6 py-4 border-t border-gray-200">
                {{ $data->withQueryString()->links() }}
            </div>
        @endif
    </div>

    <!-- Results Summary -->
    @if ($data->count() > 0)
        <div class="text-sm text-gray-600">
            @if (method_exists($data, 'total'))
                Menampilkan {{ $data->firstItem() }} - {{ $data->lastItem() }} dari {{ $data->total() }} hasil
            @else
                Menampilkan {{ $data->count() }} hasil
            @endif
        </div>
    @endif
</div>
