@props([
    'required' => false,
    'label' => 'No Label',
    'id' => 'no-id',
    'datas' => null,
    'value' => null,
])

@php
    $selectedValue = old($id) ?? $value;
@endphp

<label for="{{ $id }}" class="flex flex-col gap-1 w-full">
    <span class="font-mono">
        {{ $label }}
        @if ($required)
            <small class="text-red-500">*</small>
        @endif
    </span>

    <select name="{{ $id }}" id="{{ $id }}" @required($required)
        class="bg-neutral-100/80 border border-neutral-400 outline-0 focus:outline focus:outline-indigo-400 py-1 px-3 rounded w-full">
        <option value="">-- Select --</option>

        @foreach ($datas as $data)
            <option value="{{ $data->id }}" @selected($selectedValue == $data->id)>
                {{ $data->name }}
            </option>
        @endforeach
    </select>

    @error($id)
        <span class="text-xs text-red-600">{{ $message }}</span>
    @enderror
</label>
