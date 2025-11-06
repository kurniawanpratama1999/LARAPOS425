@extends('layouts.dashboard')
@section('title', 'Users | Larapos 425')
@section('content')
    <div class="w-full overflow-auto">
        <table class="w-fit">
            <thead class="border-b border-slate-300">
                <tr class="[&>th]:px-3 [&>th]:pb-2 [&>th]:text-left">
                    <th>Row</th>
                    <th>Name</th>
                    <th>Role</th>
                    <th>Email</th>
                    <th>Status</th>
                    <th>Created at</th>
                </tr>
            </thead>
            <tbody>
                @for ($i = 1; $i <= 10; $i++)
                    <tr id="row-data-{{ $i }}"
                        class="relative [&>td]:px-3 [&>td]:text-nowrap [&>td]:py-2 border-b border-slate-300 hover:bg-slate-100 has-checked:bg-amber-100">
                        <td id="check-{{ $i }}">
                            <label for="check-{{ $i }}">
                                <input type="checkbox" name="check-{{ $i }}" id="check-{{ $i }}">
                            </label>
                        </td>
                        <td id="name-{{ $i }}">{{ Faker\Factory::create()->name }}</td>
                        <td id="role-{{ $i }}">{{ Faker\Factory::create()->jobTitle }}</td>
                        <td id="email-{{ $i }}">{{ Faker\Factory::create()->email }}</td>
                        <td id="status-{{ $i }}">{{ Faker\Factory::create()->randomDigit }}</td>
                        <td id="created-{{ $i }}">{{ Faker\Factory::create()->date('y-m-d h:m:s') }}</td>
                    </tr>
                @endfor
            </tbody>
        </table>
    </div>
@endsection

@section('btn-group')
    <button id="btn-add" onclick="btnGoTop()" type="button"
        class="block size-10 rounded-full outline bg-emerald-500 text-white shadow">
        <i class="bi bi-plus"></i>
    </button>
    <button id="btn-delete" onclick="btnDelete()" type="button"
        class="cursor-pointer block size-10 disabled:hidden rounded-full outline bg-red-500 text-white shadow">
        <i class="bi bi-trash"></i>
    </button>
@endsection

@pushOnce('scripts')
    <script>
        function verifyEditType() {
            const verifyEl = document.querySelector("input[name='verify']")
            if (verifyEl) {
                verifyEl.addEventListener('keyup', () => {
                    const verifyVal = verifyEl.value
                    const btnSaveModalUser = document.getElementById('save-modal-user')

                    if (verifyVal === "saya sudah yakin akan melakukan perubahan") {
                        btnSaveModalUser.type = 'submit'
                        btnSaveModalUser.disabled = false
                    } else {
                        btnSaveModalUser.type = 'button'
                        btnSaveModalUser.disabled = true
                    }
                })
            }
        }

        function verifyDeleteType() {
            const verifyEl = document.querySelector("input[name='verify']")
            if (verifyEl) {
                verifyEl.addEventListener('keyup', () => {
                    const verifyVal = verifyEl.value
                    const btnSaveModalDeleteUser = document.getElementById('save-modal-delete-user')

                    if (verifyVal === "saya yakin akan menghapus data diatas") {
                        btnSaveModalDeleteUser.type = 'submit'
                        btnSaveModalDeleteUser.disabled = false
                    } else {
                        btnSaveModalDeleteUser.type = 'button'
                        btnSaveModalDeleteUser.disabled = true
                    }
                })
            }
        }

        const dataTablesEl = document.querySelectorAll('tr[id^=row-data-]')

        const btnDataTable = ({
            target
        }) => {
            const checkbox = target.querySelector('input[type=checkbox]');
            const isChecked = checkbox.checked

            checkbox.checked = !isChecked
            toggleDeleteSelectedData()
        }

        const btnDblDataTable = async ({
            target
        }) => {

            const [_, __, id] = target.id.split('-')
            const response = await fetch(`users/get-edit?id=${id}`, {
                method: "GET",
                headers: {
                    'Content-Type': 'application/json'
                }
            })
            const result = await response.json()
            const element = result.html

            document.body.insertAdjacentHTML('afterbegin', element)
            verifyEditType()
        }

        for (const dataTableEl of dataTablesEl) {
            dataTableEl.addEventListener('click', btnDataTable)
            dataTableEl.addEventListener('dblclick', btnDblDataTable)
        }


        function toggleDeleteSelectedData() {
            const checksEl = document.querySelectorAll('input[type=checkbox]')
            const btnDelete = document.getElementById('btn-delete')

            for (const checkEl of checksEl) {
                if (checkEl.checked) {
                    btnDelete.disabled = false;
                    return;
                } else {
                    btnDelete.disabled = true;
                }
            }
        }

        toggleDeleteSelectedData()

        async function btnDelete() {
            const trueChecks = []
            const checksEl = document.querySelectorAll('input[type=checkbox]')

            for (const checkEl of checksEl) {
                if (checkEl.checked) {
                    const [_, id] = checkEl.id.split('-')
                    trueChecks.push(parseInt(id))
                }
            }

            const ids = trueChecks.map(id => `id[]=${id}`).join('&')

            const response = await fetch(`users/get-delete?id=${ids}`, {
                method: "GET",
                headers: {
                    'Content-Type': 'application/json'
                }
            })
            const result = await response.json()
            const element = result.html

            document.body.insertAdjacentHTML('afterbegin', element)
            verifyDeleteType()
        }
    </script>
@endPushOnce
