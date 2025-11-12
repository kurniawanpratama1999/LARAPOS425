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

<label for="{{ $id }}"
    class="group relative mb-10 aspect-square bg-neutral-300 overflow-hidden flex items-center justify-center rounded cursor-pointer">
    <i id="dummy-image"
        class="bi bi-camera-fill block text-7xl text-neutral-400 group-hover:text-neutral-500"></i>
    <img id="img-has-upload" src="{{ asset('storage/' . $inputValue) }}" class="hidden w-full h-full object-cover absolute top-0 left-0">
    <input type="file" name="{{ $id }}" id="{{ $id }}" class="hidden" @required($required)>
    @error($id)
        <span class="text-xs text-red-600">{{ $message }}</span>
    @enderror
</label>
