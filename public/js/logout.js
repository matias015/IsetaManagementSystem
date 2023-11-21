let perfilDropdownList = document.querySelector(".perfil-lista")
let btn = document.querySelector(".perfil-logout-btn")
console.log(21);
const toggle = () => perfilDropdownList.classList.toggle("active")

window.addEventListener('click', function(e) {

    if (!btn.contains(e.target))perfilDropdownList.classList.remove('active')
    });
