@props(['links' => null])

@foreach ($links as $anchor)
    @php
        $fontBold = isset($anchor[0]) && str_contains($anchor[0], request()->path()) ? 'font-bold' : '';
    @endphp
    <a href="{{ $anchor[0] ?? '#' }}" class="{{ $fontBold }} flex flex-row gap-1 items-center">
        <i class="bi {{ $anchor[2] ?? 'bi-person-fill' }}"></i>
        <span>{{ $anchor[1] ?? 'label' }}</span>
    </a>
@endforeach
