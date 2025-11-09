@props([
    'type' => 'info', // info, success, warning, danger, error
    'title' => 'Information',
])

@php
    // Warna & ikon berdasarkan tipe
    $config = [
        'info' => [
            'bg' => 'bg-blue-400/10',
            'text' => 'text-blue-600',
            'icon' => 'bi-info-circle-fill',
        ],
        'success' => [
            'bg' => 'bg-green-400/10',
            'text' => 'text-green-600',
            'icon' => 'bi-check-circle-fill',
        ],
        'warning' => [
            'bg' => 'bg-yellow-400/10',
            'text' => 'text-yellow-600',
            'icon' => 'bi-exclamation-triangle-fill',
        ],
        'danger' => [
            'bg' => 'bg-red-400/10',
            'text' => 'text-red-600',
            'icon' => 'bi-exclamation-octagon-fill',
        ],
        'error' => [
            'bg' => 'bg-red-400/10',
            'text' => 'text-red-600',
            'icon' => 'bi-exclamation-circle-fill',
        ],
    ];

    $color = $config[$type] ?? $config['info'];
@endphp

<div {{ $attributes->merge(['class' => "p-2 shadow rounded relative text-sm {$color['bg']} {$color['text']}"]) }}
    id="alert-{{ uniqid() }}">
    <h3 class="flex items-center gap-1 font-bold italic text-base">
        <i class="bi {{ $color['icon'] }}"></i>
        <span>{{ $title }}</span>
    </h3>

    <p class="text-justify">
        {{ $slot }}
    </p>

    <button onclick="this.closest('div[id^=alert]').remove()" class="absolute block top-0 right-1 cursor-pointer">
        <i class="bi bi-x"></i>
    </button>
</div>
