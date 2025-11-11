const search = document.getElementById('search')
const tbody = document.querySelector('table#datas tbody')

const showDetail = async (id) => {
    const apiGetDetailOrderFromOrderID = await fetch(`/dashboard/transaction/detail?id=${id}`)

    const res = await apiGetDetailOrderFromOrderID.json();
    if (res.success) {
        document.body.insertAdjacentHTML('afterbegin', res.html)
    }
}

const searching = () => {
    let debounce = null
    
    search.addEventListener('keyup', () => {  
        const q = search.value
        if (debounce) {
            clearInterval(debounce)
        }

        debounce = setTimeout(async () => {
            const apiForGettingHTML = await fetch(`/dashboard/transaction/search?q=${q}`)
            const response = await apiForGettingHTML.json()
            tbody.innerHTML = response.html

        }, 400);
    })
}

document.addEventListener('DOMContentLoaded', () => {
    searching()
})