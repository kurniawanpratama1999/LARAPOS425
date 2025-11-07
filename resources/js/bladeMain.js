const theadFormTableDatas = document.querySelector('table#datas thead')
const btnDelete = document.getElementById('btn-delete')

const handleClickRow = (cb) => {
    cb.checked = !cb.checked
    const inputsCheckbox = document.querySelectorAll('table#datas input[type=checkbox]')

    for (const checkbox of inputsCheckbox) {
        if (checkbox.checked) {
            btnDelete.disabled = false;
            return;
        } else {
            btnDelete.disabled = true;
        }
    }
}

const handleDblClickRow = (id) => {
    window.location.href = 'edit/' + id
}

const toggleCheckedTableDatas = () => {
    const inputsCheckbox = document.querySelectorAll('table#datas input[type=checkbox]')

    for (const cb of inputsCheckbox) {
        if (!cb.checked) {
            btnDelete.disabled = true;
        }

        const [_, id] = cb.id.split('-')

        const tr = cb.parentElement.parentElement.parentElement;
        tr.addEventListener('click', () => handleClickRow(cb));
        tr.addEventListener('dblclick', () => handleDblClickRow(id));
    }
}

toggleCheckedTableDatas()