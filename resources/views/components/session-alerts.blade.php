@if (session('success'))
    <x-alert type="success" title="Success!" class="mb-6">
        {{ session('success') }}
    </x-alert>
@endif

@if (session('error'))
    <x-alert type="error" title="Error!" class="mb-6">
        {{ session('error') }}
    </x-alert>
@endif

@if (session('warning'))
    <x-alert type="warning" title="Warning!" class="mb-6">
        {{ session('warning') }}
    </x-alert>
@endif

@if (session('info'))
    <x-alert type="info" title="Information" class="mb-6">
        {{ session('info') }}
    </x-alert>
@endif

@if ($errors->any())
    <x-alert type="error" title="Please fix the following errors:" class="mb-6">
        <ul class="mt-2 list-disc list-inside space-y-1">
            @foreach ($errors->all() as $error)
                <li>{{ $error }}</li>
            @endforeach
        </ul>
    </x-alert>
@endif
