const btnDeleteEl = document.getElementById('btn-delete')
const btnCancelChecklistEl = document.getElementById('btn-cancel-checklist')

const handleClickRow = (cb) => {
    cb.checked = !cb.checked
    checklistWhenFirstLoad()
}

const handleDblClickRow = (id) => {
    window.location.href = `/dashboard/users/${id}/edit`
}

const checklistWhenFirstLoad = () => {
    const inputsCheckbox = document.querySelectorAll('table#datas input[type=checkbox]')
    let isExist = false;
    for (const cb of inputsCheckbox) {
        if (cb.checked) {
            isExist = true;
            break;
        }
    }

    if (isExist) {
        btnDeleteEl.disabled = false;
        btnCancelChecklistEl.disabled = false;
    } else {
        btnDeleteEl.disabled = true;
        btnCancelChecklistEl.disabled = true;
    }
}

const toggleCheckedTableDatas = () => {
    const inputsCheckbox = document.querySelectorAll('table#datas input[type=checkbox]')

    for (const cb of inputsCheckbox) {
        const [_, id] = cb.id.split('-')

        const tr = cb.parentElement.parentElement.parentElement;
        tr.addEventListener('click', () => handleClickRow(cb));
        tr.addEventListener('dblclick', () => handleDblClickRow(id));
    }
}

const btnCancelChecklist = () => {
    const inputsCheckbox = document.querySelectorAll('table#datas input[type=checkbox]')
    for (const checkbox of inputsCheckbox) {
        if (checkbox.checked) {
            checkbox.checked = false
        }
    }

    checklistWhenFirstLoad()
}

const searching = () => {
    const searchEl = document.querySelector('input#search')
    const tbody = document.querySelector('table#datas tbody');
    let debounce = null

    searchEl.addEventListener('keyup', () => {
        if (debounce) {
            clearTimeout(debounce)
        }

        debounce = setTimeout(async () => {
            const val = searchEl.value.trim()
            const response = await fetch(`/dashboard/users/search?q=${encodeURIComponent(val)}`)
            const result = await response.json();
            
            tbody.innerHTML = result.html;
            toggleCheckedTableDatas()
            checklistWhenFirstLoad()
        }, 500);
    })
}

const yesDeleteRows = async ({param}) => {
    const token = document.querySelector('meta[name=csrf-token]').getAttribute('content')
    const response = await fetch(`/dashboard/users/destroys${param}`, {
        method:"POST",
        headers: {
            'Content-Type': 'application/json',
            'X-CSRF-TOKEN': token,
        }
    })

    if (!response.ok) {
        console.log('Error!')
    } else {
        window.location.href = '/dashboard/users'
    }
}

const btnDelete = () => {

    const inputsCheckbox = document.querySelectorAll('table#datas input[type=checkbox]')
    let ids = [];
    for (const checkbox of inputsCheckbox) {
        if (checkbox.checked) {
            const [_, id] = checkbox.id.split('-');
            ids.push(id)
        }
    }
    const newIDs = ids.map(v => `id[]=${v}`).join('&')
    const param = JSON.stringify({param: `?${newIDs}`})
    
    const html = `
    <div id="asking-to-delete" class="fixed z-200 top-0 bottom-0 max-[1000px]:left-0 left-80 right-0 backdrop-blur-sm bg-black/10 flex items-center justify-center">
        <div class="max-w-[450px] bg-neutral-100 shadow rounded p-5">
            <h2 class="flex items-center gap-3 text-2xl font-bold text-red-600 mb-2">
                <i class="bi bi-question-circle"></i>
                <span>Make Sure</span>
            </h2>
            <p>Apakah kamu yakin akan menghapus data dari user id ${ids.join(" & ")} ?</p>
            <div class="flex items-center justify-end gap-4 mt-5">
                <button onclick="document.getElementById('asking-to-delete').remove()" class="font-bold px-4 py-1 text-nueutral-700">Cancel</button>
                <button onclick='yesDeleteRows(${param})' class="px-4 py-1 bg-red-400 text-white font-bold">Yes, delete it</button>
            </div>
        </div>
    </div>
    `

    document.body.insertAdjacentHTML('afterbegin', html);
}

document.addEventListener('DOMContentLoaded', () => {
    checklistWhenFirstLoad()
    toggleCheckedTableDatas()
    searching();
})