@props([
    'required' => false,
    'label' => 'No Label',
    'id' => 'no-id',
    'type' => 'text',
    'value' => '',
    'model' => null,
])

@php
    $inputValue = $type == 'password' ? '' : old($id, $model?->$id ?? $value);
@endphp

<label for="{{ $id }}" class="flex flex-col gap-1 w-full">
    <span class="font-mono">{{ $label }}

        @if ($required)
            <small class="text-red-500">*</small>
        @endif
    </span>
    <input
        class="bg-neutral-100/80 border border-neutral-400 outline-0 focus:outline focus:outline-blue-400 py-1 px-3 rounded w-full"
        type="{{ $type }}" name="{{ $id }}" id="{{ $id }}" autocomplete="off" autocorrect="off"
        spellcheck="false" value="{{ $inputValue }}" {{ $attributes }}>
    @error($id)
        <span class="text-xs text-red-600">{{ $message }}</span>
    @enderror
</label>
