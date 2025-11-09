@props(['color' => 'neutral', 'href' => null])

@php
    switch ($color) {
        case 'red':
            $variant = 'bg-red-500/20 hover:bg-red-500';
            break;
        case 'green':
            $variant = 'bg-green-500/20 hover:bg-green-500';
            break;
        case 'blue':
            $variant = 'bg-blue-500/20 hover:bg-blue-500';
            break;
        case 'dark':
            $variant = 'bg-neutral-500/20 hover:bg-neutral-500';
            break;
        default:
            $variant = 'bg-neutral-500/20 hover:bg-neutral-500';
            break;
    }

    $className = "block flex items-center justify-center disabled:hidden size-12 rounded-full outline $variant text-white shadow";
@endphp

@if ($href)
    <a href="{{ $href }}" {{ $attributes->merge(['class' => $className]) }}>
        {{ $slot }}
    </a>
@else
    <button {{ $attributes->merge(['class' => $className]) }}>
        {{ $slot }}
    </button>
@endif
