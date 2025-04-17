const toggleButton = document.getElementById('desplegable-btn');
const sidebar = document.getElementById('sidebar');
const body = document.body;

function show() {
    const isClosed = sidebar.classList.toggle('close');
    const button = document.querySelector('.desplegable');

    if (isClosed) {
        body.classList.add('sidebar-closed');
        button.classList.remove('open'); 
    } else {
        body.classList.remove('sidebar-closed');
        button.classList.add('open'); 
    }
}

function toggleSubMenu(button){
    const parent = button.closest('.dropdown');
    const submenu = parent.querySelector('.sub-menu'); 
    submenu.classList.toggle('showw');
}

window.addEventListener('DOMContentLoaded', () => {
    const button = document.querySelector('.desplegable');
    const isClosed = sidebar.classList.contains('close');

    if (!isClosed) {
        // x = sidebar abieto
        button.classList.add('open');
        body.classList.remove('sidebar-closed');
    } else {
        // hamburguesa = sidebar cerrado
        button.classList.remove('open');
        body.classList.add('sidebar-closed');
    }
});
