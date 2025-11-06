<!DOCTYPE html>
<html class="h-full bg-neutral-200" lang="{{ str_replace('_', '-', app()->getLocale()) }}">

<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">

    <title>@yield('title', 'LARAPOS425')</title>

    @vite(['resources/css/app.css', 'resources/js/app.js'])
</head>

<body class="h-full">

    <header
        class="bg-neutral-200 z-49 fixed top-0 left-80 w-[calc(100dvw-20rem)] h-12 border-b border-slate-300 flex flex-row gap-3 items-center px-3 max-[1000px]:left-0 max-[1000px]:w-full">

        <h1 class="font-bold text-xl hidden max-[1000px]:block">LARAPOS 425</h1>
        <button onclick="toggleMenu()" id="btn-menu" type="button"
            class="hidden max-[1000px]:block cursor-pointer text-xl">
            <i class="bi bi-list"></i>
        </button>
        <label for="search"
            class="px-3 max-[1000px]:ml-auto w-full max-w-sm border rounded-full border-slate-400 flex flex-row items-center justify-center">
            <i class="bi bi-search"></i>
            <input type="text" name="search" id="search" placeholder="search"
                class="border-0 outline-0 py-1 px-3 w-full">
        </label>
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
                    <a href="#" class="flex flex-row gap-1 items-center">
                        <i class="bi bi-journal-plus"></i>
                        <span>Create Order</span>
                    </a>
                    <a href="#" class="flex flex-row gap-1 items-center">
                        <i class="bi bi-journal"></i>
                        <span>View Orders</span>
                    </a>
                    <a href="#" class="flex flex-row gap-1 items-center">
                        <i class="bi bi-journal-text"></i>
                        <span>Logging</span>
                    </a>
                </div>
            </div>

            <div class="flex flex-col gap-2">
                <h2 class="font-bold text-indigo-400 text-xl">Master Data</h2>
                <div class="flex flex-col pl-2 gap-2">
                    <a href="#" class="flex flex-row gap-1 items-center">
                        <i class="bi bi-people"></i>
                        <span>User Collection</span>
                    </a>
                    <a href="#" class="flex flex-row gap-1 items-center">
                        <i class="bi bi-person-up"></i>
                        <span>User Roles</span>
                    </a>
                    <a href="#" class="flex flex-row gap-1 items-center">
                        <i class="bi bi-shop"></i>
                        <span>Product Collection</span>
                    </a>
                    <a href="#" class="flex flex-row gap-1 items-center">
                        <i class="bi bi-basket"></i>
                        <span>Product Categories</span>
                    </a>
                </div>
            </div>
        </nav>

        <div class="mt-auto p-4 flex flex-col gap-2">
            <a href="#" class="flex flex-row gap-1 items-center">
                <i class="bi bi-person"></i>
                <span>Kurniawan Pratama</span>
            </a>
            <a href="#" class="flex flex-row gap-1 items-center">
                <i class="bi bi-power"></i>
                <span>Logout</span>
            </a>
        </div>
    </aside>
    <main
        class="relative top-12 left-80 w-[calc(100dvw-20rem)] h-[200dvh] overflow-auto p-3 max-[1000px]:w-full max-[1000px]:left-0">
        @yield('content')

        <div id="btn-group-control" class="fixed bottom-5 right-5 flex flex-col gap-2">
            @yield('btn-group')

            <button id="btn-gotop" onclick="btnGoTop()" type="button"
                class="block disabled:hidden size-10 rounded-full outline bg-neutral-500 text-white shadow">
                <i class="bi bi-caret-up-fill"></i>
            </button>
        </div>
    </main>
    <script>
        function toggleMenu() {
            const asideEl = document.querySelector('aside')
            asideEl.classList.toggle('max-[1000px]:-left-80')
        }

        function btnGoTop() {
            window.scrollTo({
                top: 0,
                behavior: 'smooth'
            })
        }

        const btnGoTopEl = document.getElementById('btn-gotop')

        if (window.screenY < 50) {
            btnGoTopEl.disabled = true
        }

        window.addEventListener('scroll', (e) => {
            const scrollPos = window.scrollY
            if (scrollPos < 50) {
                btnGoTopEl.disabled = true
            } else {
                btnGoTopEl.disabled = false
            }
        })
    </script>
    @stack('scripts')
</body>

</html>
