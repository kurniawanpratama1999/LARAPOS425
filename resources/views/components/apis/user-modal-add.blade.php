<div id="add-modal-user"
    class="fixed z-100 top-0 left-0 bottom-0 right-0 flex flex-col items-center justify-center gap-1 bg-white/20 backdrop-blur-md">
    <div class="relative  p-3 w-full max-w-[450px] bg-neutral-100 shadow">
        <div>
            <h2 class="font-bold text-indigo-500">Add User</h2>
            <p class="text-xs text-yellow-700 mt-2 p-2 bg-yellow-400/10 outline outline-yellow-500">Kamu ada di mode tambah user, pastikan Email dan Password dimasukan dengan benar.</p>
        </div>
        <form id="users-store" class="mt-5 grid grid-cols-2 gap-5">
            @csrf

            <label for="name" class="flex flex-col border border-indigo-300 p-2 rounded-md gap-1">
                <span class="text-sm text-indigo-500">Fullname <small>*</small></span>
                <input type="text" name="name" id="name" value="{{ old('name') }}"
                    class="w-full border-0 outline-0">
            </label>

            <label for="email" class="flex flex-col border border-indigo-300 p-2 rounded-md gap-1">
                <span class="text-sm text-indigo-500">Email Address <small>*</small></span>
                <input type="email" name="email" id="email" value="{{ old('email') }}"
                    class="w-full border-0 outline-0">
            </label>

            <label for="role_id" class="flex flex-col border border-indigo-300 p-2 rounded-md gap-1">
                <span class="text-sm text-indigo-500">Role Name <small>*</small></span>
                <input type="text" name="role_id" id="role_id" value="{{ old('role_id') }}"
                    class="w-full border-0 outline-0">
            </label>

            <label for="password" class="flex flex-col border border-indigo-300 p-2 rounded-md gap-1">
                <span class="text-full text-indigo-500">Password <small>*</small></span>
                <input type="text" name="password" id="password" value="" class="w-full border-0 outline-0">
            </label>

            <div class="col-span-2 flex flex-row gap-2 mt-5 w-fit ml-auto font-bold">
                <button id="close-modal-user" onclick="document.getElementById('add-modal-user').remove()"
                    type="button" class="px-3 cursor-pointer py-1">Close</button>
                <button id="add-modal-user" type="submit"
                    class="disabled:bg-neutral-500 px-3 cursor-pointer py-1 rounded-md bg-emerald-300 text-white">Add User</button>
            </div>
        </form>
    </div>
</div>
