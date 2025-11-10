@extends('layouts.dashboard')
@section('title', 'Categories | Larapos 425')
@section('content')
    <div class="flex flex-col items-center p-3">
        <div class="max-w-lg">
            @if (isset($datas))
                <x-alert title="information" type="info">
                    Pastikan kamu mengeditnya dengan data category name yang belum ada.
                </x-alert>
            @else
                <x-alert title="information" type="info">
                    Category name haruslah unik, jadi pastikan kamu membuat nama yang memang belum ada.
                </x-alert>
            @endif

            <div class="my-3">
                <h2 class="text-2xl {{ !isset($datas) ? 'text-emerald-400' : 'text-indigo-400' }} font-bold">
                    @if (isset($datas))

                        Update For {{ $datas->name }}
                    @else
                        Create New Category
                    @endif
                </h2>

                <p class="text-justify">
                    @if (isset($datas))
                        Data ini akan diperbaharui oleh administrator. Pastikan diperbaharui dengan
                        benar.
                    @else
                        Data ini digunakan sebagai relasi untuk si transaction.
                    @endif
                </p>
            </div>

            <form action="{{ !isset($datas) ? route('products.store') : route('products.update', $datas->id) }}"
                method="post" class="p-2 w-full max-w-lg space-y-5">
                @csrf
                @if (isset($datas))
                    @method('PUT')
                @endif
                {{ $datas->status }}
                <x-form.input required label="Name" id="name" type="text" :model="$datas ?? null" autofocus />
                <x-form.select required label="Category Name" id="categories_id" :datas="$categories" :value="$datas?->categories_id ?? ''"/>
                <x-form.input required label="Description" id="description" type="text" :model="$datas ?? null" autofocus />
                <x-form.input required label="Price" id="price" type="text" :model="$datas ?? null" autofocus />
                <x-form.input required label="Quantity" id="quantity" type="number" :model="$datas ?? null" autofocus />

                    @if (isset($datas))
                    <x-form.select required label="Status" id="status" :datas="collect([
                            (object)['id' => 1, 'name' => 'Active'],
                            (object)['id' => 0, 'name' => 'Non Active'],
                        ])" :value="$datas?->status ?? ''"/>
                    @endif

                <div class="flex flex-row gap-4 justify-end">
                    <button type="reset" class="font-bold w-20">Reset</button>

                    <button type="submit"
                        class="font-bold w-20 {{ !isset($datas) ? 'bg-emerald-400 hover:bg-emerald-500' : 'bg-indigo-400 hover:bg-indigo-500' }} py-1 rounded text-white cursor-pointer">
                        @if (isset($datas))
                            Update
                        @else
                            Save
                        @endif
                    </button>
                </div>
            </form>
        </div>
    </div>

    <script>
        console.log({{ Js::from($datas) }})
    </script>
@endsection
