@extends('layouts.dashboard')
@section('title', 'Categories | Larapos 425')
@section('content')
    <table id="datas" class="w-full relative">
        <thead class="sticky top-0 z-1 bg-neutral-200 text-left">
            <tr>
                <th class="text-center">row</th>
                <th>name</th>
                <th>created</th>
            </tr>
        </thead>
        <tbody>
            @foreach ($datas as $key => $category)
                <tr class="relative hover:bg-black/10 transition-[background]">
                    <td>
                        <div class='text-center'>{{ str_pad($key += 1, 2, '0', STR_PAD_LEFT) }}</div>
                        <x-table.checkrow id="check-{{ $category->id }}" />
                    </td>
                    <td class="pl-0!">{{ $category->name }}</td>
                    <td>{{ $category->created_at }}</td>
                </tr>
            @endforeach
        </tbody>
    </table>
@endsection

@section('btn-group')
    <x-floating-button href="{{ route('categories.create') }}" id="btn-add" color="green">
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
    <script src="{{ Vite::asset('resources/js/bladeCategoriesMain.js') }}"></script>
@endPushOnce
