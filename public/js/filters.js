const button = document.querySelector('#show-filters');
const filters = document.querySelector('#filters');

button.onclick = function(){
    filters.classList.toggle('none');
}