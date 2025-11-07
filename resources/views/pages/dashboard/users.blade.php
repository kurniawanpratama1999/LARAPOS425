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
            <tbody id="table-data">
                <x-apis.user-table-data :users="$users"/>
            </tbody>
        </table>
    </div>
@endsection

@section('btn-group')
    <button id="btn-add" onclick="btnAdd()" type="button"
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
        const btnDelete = async () => {
            const trueChecks = []
            const checksEl = document.querySelectorAll('input[type=checkbox]')

            for (const checkEl of checksEl) {
                if (checkEl.checked) {
                    const [_, id] = checkEl.id.split('-')
                    trueChecks.push(parseInt(id))
                }
            }

            const ids = trueChecks.map(id => `id[]=${id}`).join('&')

            const response = await fetch(`users/get-delete?${ids}`, {
                method: "GET",
                headers: {
                    'Content-Type': 'application/json'
                }
            })
            const result = await response.json()
            const element = result.html

            document.body.insertAdjacentHTML('afterbegin', element)
            verifyDeleteType()
        };

        const btnAdd = async () => {
            const response = await fetch("/dashboard/users/add", {
                method: "GET",
                headers: {"Content-type": "application/json"}
            })

            const result = await response.json();
            const element = result.html;
            document.body.insertAdjacentHTML('afterbegin', element)

            formStoreUser()
        };

        const verifyEditType = () => {
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

        const verifyDeleteType = () => {
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

        const toggleDeleteSelectedData = () => {
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

        const handleClickRow = ({target}) => {
            const checkbox = target.querySelector('input[type=checkbox]');
            const isChecked = checkbox.checked

            checkbox.checked = !isChecked
            toggleDeleteSelectedData()
        }

        const handleDblClickRow = async ({target}) => {
            const dataTablesEl = document.querySelectorAll('tr[id^=row-data-]')
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

        const activedHandleClickForRow = () => {
            const dataTablesEl = document.querySelectorAll('tr[id^=row-data-]')
            for (const dataTableEl of dataTablesEl) {
                dataTableEl.addEventListener('click', handleClickRow)
                dataTableEl.addEventListener('dblclick', handleDblClickRow)
            }
        }

        const handleSearchData = () => {
            const searchEl = document.querySelector('input[name=search]')

            let debounceSearch = null;
            searchEl.addEventListener('keyup', () => {

                if (debounceSearch) {
                    clearTimeout(debounceSearch)
                }

                debounceSearch = setTimeout(async() => {
                    const q = searchEl.value;
                        const url = q ? `/dashboard/users/search?q=${q}` : `/dashboard/users/search`;
                        const response = await fetch(url, {
                            method: "GET",
                            headers: {"Content-type": "application/json"}
                        })

                        const result = await response.json();

                        const element = result.html;

                        document.getElementById('table-data').innerHTML = element;

                        activedHandleClickForRow()
                    }, 400)
            })
        }

        const autoDeleteMessage = () => {
            const messageEl = document.getElementById('message')

            if (messageEl) {
                setTimeout(() => {
                    messageEl.remove()
                }, 2000)
            }
        }

        const formStoreUser = () => {
            const userstoreEl = document.getElementById('users-store');

            userstoreEl.addEventListener('submit',async (e)=> {
                e.preventDefault();
                const form = e.target;
                const formData = new FormData(form);

                try {
                    const res = await fetch("{{ route('users.store') }}", {
                        method: 'POST',
                        headers: {"X-CSRF-TOKEN":"{{ csrf_token() }}"},
                        body: formData,
                    })

                    const data = await res.json();

                    userstoreEl.insertAdjacentHTML('afterbegin', data.html);
                    return;
                } catch (error) {
                    userstoreEl.insertAdjacentHTML('afterbegin', `<x-apis.Message :success="false" message="error"/>`);
                } finally {
                    autoDeleteMessage();
                }

            })
        }

        const run = () => {
                activedHandleClickForRow();
                handleSearchData();
                toggleDeleteSelectedData();
        }

        document.addEventListener('DOMContentLoaded', run);
    </script>
@endPushOnce
