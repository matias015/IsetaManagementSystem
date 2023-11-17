let perfilDropdownList = _find(".perfil-lista")
let btn = _find(".perfil-logout-btn")

btn.when('click', function(e) {
    perfilDropdownList.toggleClass('active')
});

const btnNav = _find('.navOpenBtn')
const nav = _find('.nav-links')
const btnClose = _find('.navCloseBtn')

btnNav.when('click',function(e){
    nav.toggleClass('left-hide')
})

btnClose.when('click',function(e){
    nav.toggleClass('left-hide')
})