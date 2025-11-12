@extends('layouts.dashboard')
@section('title', 'product | Larapos 425')
@section('content')
    <table id="datas" class="w-full relative">
        <thead class="sticky top-0 z-1 bg-neutral-200 text-left">
            <tr>
                <th class="text-center">row</th>
                <th>Name</th>
                <th>category</th>
                <th>created</th>
            </tr>
        </thead>
        <tbody>
            @foreach ($datas as $key => $product)
                <tr class="relative hover:bg-black/10 transition-[background]">
                    <td>
                        <div class='text-center'>{{ str_pad($key += 1, 2, '0', STR_PAD_LEFT) }}</div>
                        <x-table.checkrow id="check-{{ $product->id }}" />
                    </td>
                    <td class="pl-0!">
                        <div class="flex items-center gap-2">
                            @if ($product->photo_product)
                            <div class="size-15 rounded-full shadow">
                                <img src="{{ asset('storage/' . $product->photo_product) }}" alt="{{ $product->name}}" class="rounded-full object-cover w-full h-full">
                            </div>
                            @else
                            <div class="size-15 rounded-full shadow text-2xl flex items-center justify-center">
                                @switch(strtolower($product->categories->name))
                                    @case("makanan")
                                        <i class="bi bi-fork-knife"></i>
                                        @break
                                    @case("minuman")
                                        <i class="bi bi-cup-hot-fill"></i>
                                        @break
                                    @default
                                        <i class="bi bi-cup-hot-fill"></i>
                                @endswitch
                            </div>
                            @endif
                            <span>{{ $product->name }}</span>
                        </div>
                    </td>
                    <td class="pl-0!">{{ $product->categories->name }}</td>
                    <td>{{ $product->created_at }}</td>
                </tr>
            @endforeach
        </tbody>
    </table>
@endsection

@section('btn-group')
    <x-floating-button href="{{ route('products.create') }}" id="btn-add" color="green">
        <i class="bi bi-plus text-2xl"></i>
    </x-floating-button>

    <x-floating-button id="btn-delete" color="red" onclick="btnDelete()" type="button" disabled>
        <i class="bi bi-trash"></i>
    </x-floating-button>

    <x-floating-button id="btn-cancel-checklist" color="blue" onclick="btnCancelChecklist()" type="button" disabled>
        <i class="bi bi-x"></i>
    </x-floating-button>
@endsection

@pushOnce('scripts')
    <script src="{{ Vite::asset('resources/js/bladeProductsMain.js') }}"></script>
@endPushOnce
