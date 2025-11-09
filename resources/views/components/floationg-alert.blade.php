@props([
    'type' => 'info', // info, success, warning, danger, error
    'title' => 'Information',
])

@php
    // Warna & ikon berdasarkan tipe
    $config = [
        'info' => [
            'text' => 'text-blue-600',
            'icon' => 'bi-info-circle-fill',
        ],
        'success' => [
            'text' => 'text-green-600',
            'icon' => 'bi-check-circle-fill',
        ],
        'warning' => [
            'text' => 'text-yellow-600',
            'icon' => 'bi-exclamation-triangle-fill',
        ],
        'danger' => [
            'text' => 'text-red-600',
            'icon' => 'bi-exclamation-octagon-fill',
        ],
        'error' => [
            'text' => 'text-red-600',
            'icon' => 'bi-exclamation-circle-fill',
        ],
    ];

    $color = $config[$type] ?? $config['info'];
@endphp

<div id="floating-alert-{{ uniqid() }}"
    class='fixed z-200 top-0 bottom-0 left-80 right-0 bg-black/10 backdrop-blur-sm flex items-center justify-center p-5'>
    <div {{ $attributes->merge(['class' => 'max-w-[450px] p-5 shadow rounded relative text-sm bg-neutral-100']) }}>
        <h3 class="flex items-center gap-3 font-bold italic text-4xl {{ $color['text'] }}">
            <i class="bi {{ $color['icon'] }}"></i>
            <span>{{ $title }}</span>
        </h3>

        <p class="text-justify mt-4">
            {{ $slot }}
        </p>

        <button onclick="closeFloatingAlert()"
            class="block cursor-pointer mt-7 px-5 py-2 bg-neutral-500 text-white rounded w-fit ml-auto">
            Close
        </button>
    </div>
</div>

@pushOnce('scripts')
    <script>
        const floatingAlertEl = document.querySelector('div[id^=floating-alert]')
        let debounceFloatingAlert = null

        const closeFloatingAlert = () => {
            if (floatingAlertEl) {
                floatingAlertEl.remove();
                clearTimeout(debounceFloatingAlert)
            }
        }

        debounceFloatingAlert = setTimeout(() => {
            if (!floatingAlertEl) {
                clearTimeout(() => {}, 7000)
            }

            closeFloatingAlert();
        }, 7000)
    </script>
@endPushOnce
