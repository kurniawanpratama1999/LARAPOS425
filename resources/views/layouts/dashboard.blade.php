<!DOCTYPE html>
<html class="h-full bg-neutral-200" lang="{{ str_replace('_', '-', app()->getLocale()) }}">

<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <meta name="csrf-token" content="{{ csrf_token() }}">

    <title>@yield('title', 'LARAPOS425')</title>

    @vite(['resources/css/app.css', 'resources/js/app.js'])
</head>

<body class="h-full">

    @php
        $currentUrl = request()->path();
        $isCurrentUrlContainCreate = str_contains($currentUrl, 'create');
        $isCurrentUrlContainUpdate = str_contains($currentUrl, 'edit');
        $isContain = $isCurrentUrlContainCreate || $isCurrentUrlContainUpdate;
        $previousUrl = url()->previous(true);

        $floatingAlert = session('floatingAlert');
    @endphp

    @if ($floatingAlert)
        <x-floationg-alert :title="$floatingAlert['title']" :type="$floatingAlert['type']">
            {{ $floatingAlert['message'] }}
        </x-floationg-alert>
    @endif

    <header
        class="bg-neutral-200 z-49 fixed top-0 left-80 w-[calc(100dvw-20rem)] h-12 border-b border-slate-300 flex flex-row gap-3 items-center px-3 max-[1000px]:left-0 max-[1000px]:w-full">

        <h1 class="font-bold text-xl hidden max-[1000px]:block">LARAPOS 425</h1>
        <button onclick="toggleMenu()" id="btn-menu" type="button"
            class="hidden max-[1000px]:block cursor-pointer text-xl">
            <i class="bi bi-list"></i>
        </button>

        @if ($isContain)
            <a href="{{ $previousUrl }}" class="text-neutral-700 max-[1000px]:ml-auto">
                <i class="bi bi-chevron-left"></i>
                <span>Back</span>
            </a>
        @else
            <label for="search"
                class="px-3 max-[1000px]:ml-auto w-full max-w-sm border rounded-full border-slate-400 flex flex-row items-center justify-center">
                <i class="bi bi-search"></i>
                <input type="text" name="search" id="search" placeholder="search"
                    class="border-0 outline-0 py-1 px-3 w-full">
            </label>
        @endif
    </header>

    <aside
        class="bg-neutral-200 max-[1000px]:z-50 fixed top-0 bottom-0 left-0 max-[1000px]:top-12 max-[1000px]:-left-80 w-xs border-r border-slate-300 flex flex-col transition-[left]">
        <div class="h-12 flex flex-col justify-center px-3 max-[1000px]:hidden">
            <h1 class="font-bold text-xl">LARAPOS 425 <small>versi 1.0</small></h1>
        </div>
        <nav class="flex flex-col gap-8 px-4 pt-5">
            <div class="flex flex-col gap-2">
                <h2 class="font-bold text-indigo-400 text-xl">Transaction</h2>
                <div class="flex flex-col pl-2 gap-2">
                    <x-current-url :links="[
                        ['/dashboard/transaction/create', 'Create Transaction', 'bi-journal-plus'],
                        ['/dashboard/transaction', 'Transaction History', 'bi-journal'],
                        ['/dashboard/logging', 'Logging', 'bi-journal-text'],
                    ]" />
                </div>
            </div>

            @if (auth()->check() && in_array(strtolower(auth()->user()->role?->name), ['admin','administrator']))
                <div class="flex flex-col gap-2">
                    <h2 class="font-bold text-indigo-400 text-xl">Master Data</h2>
                    <div class="flex flex-col pl-2 gap-2">
                        @php
                            $arrLink = [
                                ['/dashboard/roles', 'User Roles', 'bi-person-up'],
                                ['/dashboard/categories', 'Product Categories', 'bi-basket'],
                                ['/dashboard/users', 'Users Collection', 'bi-people'],
                            ];

                            if (\App\Models\Categories::count() > 0) {
                                $arrLink[] = ['/dashboard/products', 'Products Collection', 'bi-shop'];
                            }
                        @endphp
                        <x-current-url :links="$arrLink" />
                    </div>
                </div>
            @endif
        </nav>

        <div class="mt-auto p-4 flex flex-col gap-2">
            <a href="#" class="flex flex-row gap-1 items-center">
                <i class="bi bi-person"></i>
                <span>{{ auth()->user()->name }}</span>
            </a>
            <a href="/logout" class="flex flex-row gap-1 items-center">
                <i class="bi bi-power"></i>
                <form action="/logout" method="post">
                    @csrf
                    <button type="submit">logout</button>
                </form>
            </a>
        </div>
    </aside>
    <main
        class="fixed top-12 left-80 w-[calc(100dvw-20rem)] h-[calc(100dvh-3rem)] overflow-auto max-[1000px]:w-full max-[1000px]:left-0">
        @yield('content')

        <div id="btn-group-control" class="fixed bottom-5 right-5 flex flex-col gap-2">
            @yield('btn-group')

            <x-floating-button id="btn-gotop" onclick="btnGoTop()" type="button" disabled>
                <i class="bi bi-caret-up-fill"></i>
            </x-floating-button>
        </div>
    </main>
    <script src="{{ Vite::asset('resources/js/bladeDashboard.js') }}"></script>
    @stack('scripts')
</body>

</html>
