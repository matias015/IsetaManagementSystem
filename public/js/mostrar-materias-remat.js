// const carreraSelect = document.querySelector('#carrera_select')
// const asignaturaSelect = document.querySelector('#asignatura_select')
// const bodyTable = document.querySelector('#body-table')
// console.log(2);
// carreraSelect.addEventListener('change',function(){
//     bodyTable.innerHTML = '';

//     fetch(BASE_URL + `api/a/${carreraSelect.value}`)
//         .then( data => data.json())
//         .then(data=>{
//             data.forEach(element => {

//                 const select = _newNode({tag: 'select', attrs:{'name': element.id}, childrens: [
//                     _newNode({tag: 'option', content: 'Modalidad', attrs:{'value': 0, 'selected':true}}),
//                     _newNode({tag: 'option', content: 'Libre', attrs:{'value': 1}}),
//                     _newNode({tag: 'option', content: 'Regular', attrs:{'value': 2}})
//                 ]})

//                 _newNode({
//                     tag: 'tr',
//                     parent: bodyTable,
//                     childrens:[
//                         _newNode({tag: 'td', content: element.nombre}),
//                         _newNode({tag: 'td', childrens:[select]}),
//                     ]
//                 })

//             });
            
//         })
// })