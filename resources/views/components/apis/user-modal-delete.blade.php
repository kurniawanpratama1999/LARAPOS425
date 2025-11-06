<div id="modal-delete-user"
    class="fixed z-100 top-0 left-0 bottom-0 right-0 flex flex-col items-center justify-center gap-1 bg-white/20 backdrop-blur-md">
    <div class="p-3 w-full max-w-[450px] bg-neutral-100 shadow">
        <div>
            <h2 class="font-bold text-indigo-500">Delete Users</h2>
            <p class="text-xs text-yellow-700 mt-2 p-2 bg-yellow-400/10 outline outline-yellow-500">
                Kamu sedang melakukan delete user, pastikan data dibawah adalah yang ingin dihapus.
            </p>
        </div>
        <form action="" method="" class="mt-5 grid grid-cols-2 gap-5">
            @csrf
            @method('DELETE')

            <div class="relative col-span-2 w-full max-h-[30vh] overflow-auto">
                <thead class="sticky top-0 bg-neutral-100 border-b border-slate-300">
                    <tr class="[&>th]:px-3 [&>th]:pb-2 [&>th]:text-left">
                        <th>Name</th>
                        <th>Role</th>
                        <th>Email</th>
                    </tr>
                </thead>
                <tbody>
                    @foreach ($userDelete as $user)
                        <tr class="[&>td]:px-3 [&>td]:text-nowrap [&>td]:py-2 border-b border-slate-300">
                            <td>{{ $user['name'] }}</td>
                            <td>{{ $user['role_name'] }}</td>
                            <td>{{ $user['email'] }}</td>
                        </tr>
                    @endforeach
                </tbody>
                </table>
            </div>

            <div class="col-span-2">
                <label for="verify" class="flex flex-col border border-indigo-300 p-2 rounded-md gap-1">
                    <span class="text-sm text-indigo-500">Verify <small>*</small></span>
                    <input type="text" name="verify" id="verify" class="w-sm border-0 outline-0">
                </label>
                <span class="text-xs text-red-500">Ketik "saya yakin akan menghapus data diatas"</span>
            </div>

            <div class="col-span-2 flex flex-row gap-2 mt-5 w-fit ml-auto font-bold">
                <button id="close-modal-delete-user" onclick="document.getElementById('modal-delete-user').remove()"
                    type="button" class="px-3 cursor-pointer py-1">Close</button>
                <button id="save-modal-delete-user" type="button"
                    class="disabled:bg-neutral-500 px-3 cursor-pointer py-1 rounded-md bg-red-300 text-white"
                    disabled>Delete</button>
            </div>
        </form>
    </div>
</div>
