@props(['class' => ''])

<div {{ $attributes->merge(['class' => "flex items-center $class"]) }}>
    <div
        class="w-10 h-10 bg-gradient-to-br from-amber-500 to-orange-600 rounded-lg flex items-center justify-center shadow-lg">
        <span class="text-white font-bold text-lg font-serif">S</span>
    </div>
    <span class="ml-2 text-xl font-bold text-gray-800 font-serif">Songket Palembang</span>
</div>
