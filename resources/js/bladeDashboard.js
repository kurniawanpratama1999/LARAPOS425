const mainEl = document.querySelector('main')
const btnGoTopEl = document.getElementById('btn-gotop')

function btnGoTop() {
    mainEl.scrollTo({
        top: 0,
        behavior: 'smooth'
    })
}
        
const toggleBtnGoTop = () => {
    if (mainEl.scrollTop < 100) {
        btnGoTopEl.disabled = true
    }

    mainEl.addEventListener('scroll', (e) => {
        const scrollY = mainEl.scrollTop

        if (scrollY < 100) {
            btnGoTopEl.disabled = true
        } else {
            btnGoTopEl.disabled = false
        }

        if (scrollY < 3) {
            theadFormTableDatas.classList.remove('shadow')
        } else {
            theadFormTableDatas.classList.add('shadow')
        }
    })
}

toggleBtnGoTop()