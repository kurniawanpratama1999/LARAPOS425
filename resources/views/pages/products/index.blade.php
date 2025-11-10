@extends('layouts.dashboard')
@section('title', 'product | Larapos 425')
@section('content')
    <table id="datas" class="w-full relative">
        <thead class="sticky top-0 z-1 bg-neutral-200 text-left">
            <tr>
                <th class="text-center">row</th>
                <th colspan="2">Name</th>
                <th>Category Name</th>
                <th>Description</th>
                <th>price</th>
                <th>quantity</th>
                <th>status</th>
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
                    <td>
                        <div
                            class="size-9 outline-2 outline-neutral-400 rounded-full bg-slate-500 flex items-center justify-center overflow-hidden">
                            @if ($product->photo_product)
                                <img src="/storage/{{ $product->photo_product }}" alt="{{ $product->name }}">
                            @else
                                <i class="bi bi-person-fill text-2xl text-slate-50 mb-1"></i>
                            @endif
                        </div>
                    </td>
                    <td class="pl-0!">{{ $product->name }}</td>
                    <td class="pl-0!">{{ $product->categories->name }}</td>
                    <td>{{ $product->description }}</td>
                    <td>{{ $product->price }}</td>
                    <td>{{ $product->quantity }}</td>
                    <td>
                        @if ($product->status = 1)
                            Active
                        @elseif($product->status = 2)
                            Non Active
                        @else
                            Not Found
                        @endif
                    </td>
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
