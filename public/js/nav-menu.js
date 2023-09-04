
let perfilDropdownList = document.querySelector(".perfil-lista")
let btn = document.querySelector(".perfil-logout-btn")


btn.addEventListener('click', function(e) {
    perfilDropdownList.classList.toggle('active')
});

const btnNav = _find('.navOpenBtn')
const nav = _find('.nav-links')
const btnClose = _find('.navCloseBtn')

btnNav.addEventListener('click',function(e){
    nav.classList.toggle('left-hide')
})

btnClose.addEventListener('click',function(e){
    nav.classList.toggle('left-hide')
})