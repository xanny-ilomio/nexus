const dateElement = document.querySelector(".date");
const helloElement = document.querySelector(".hello");

// DATE 
function formatDate(date){
    const days = ["Domingo", "Lunes", "Martes", "Miércoles", "Jueves", "Viernes", "Sábado"];
    const months = ["Enero", "Febrero", "Marzo", "Abril", "Mayo", "Junio", "Julio", "Agosto", "Septiembre", "Octubre", "Noviembre", "Diciembre"];

    return `${days[date.getDay()]}, ${months[date.getMonth()]} ${date.getDate()}`;
}

setInterval(()=>{
    const now = new Date();

    dateElement.textContent = formatDate(now);
    helloElement.textContent = formatHello(now);
},200);

// WELCOMEEEE
function formatHello(date){
    const useri = document.querySelector(".welcome").dataset.user;
    const hours = date.getHours();
    if(hours<=11 && hours>=5){
        return `Buenos días, ${useri}`; //ADD NAME USER ${}
    } else if(hours>=12 && hours<=18){
        return `Buenas tardes, ${useri}`;
    } else{
        return `Buenas noches, ${useri}`;
    }
}

