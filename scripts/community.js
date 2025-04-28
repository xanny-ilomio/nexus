// SIDEBAR
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

// SEARCH BOX AUTOCOMPLETE

    //filter the keywords autocomplete  
let availableKeywords = [
    // add the proyects
    'proyecto',
    'proyecto',
    'proyecto',
    'proyecto',
    'proyecto',
    'nose',
];
const resultBox = document.querySelector(".result-box");
const inputBox = document.getElementById("input-box");

inputBox.onkeyup = function(){
    let result=[];
    let input = inputBox.value;
    if(input.length){
        result= availableKeywords.filter((keyword)=>{
            return keyword.toLowerCase().includes(input.toLowerCase());
        });
    }
    display(result);

    if(!result.length){
        resultBox.innerHTML= '';
    }
}

    //display the autocomplete
function display(result){
    const content = result.map((list)=>{
        return"<li onclick=selectInput(this)>" + list + "</li>";
    });
    resultBox.innerHTML = "<ul>" +content.join('')+ "</ul>";
}

function selectInput(list){
    inputBox.value = list.innerHTML;
    resultBox.innerHTML = ' ';
}

inputBox.addEventListener('focus', () => {
    document.querySelector('.header').classList.add('active');
    document.querySelector('.search-box').classList.add('active');
});

inputBox.addEventListener('blur', () => {
    setTimeout(() => {
        document.querySelector('.header').classList.remove('active');
        document.querySelector('.search-box').classList.remove('active');
    }, 200);
});
