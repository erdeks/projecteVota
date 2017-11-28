window.addEventListener('load', onLoad, true);

function onLoad(){
    inicializarNieve(100);
}

function inicializarNieve(velocidad){
    var i, x, y;
    var anchuraMax=window.screen.availWidth;
    var alturaMax=window.screen.availHeight;
    var numeroCopos = parseInt(anchuraMax / 30 + alturaMax / 30);
    var copos = new Array(numeroCopos);
    for (i = 0; i<numeroCopos; i++){
        x = parseInt(Math.random()*anchuraMax);
        y = parseInt(Math.random()*alturaMax) - 20;
        copos[i] = dibujaCopo(x,y);
    }

    setInterval(nevar, velocidad, copos, alturaMax);
}

// Función inicial que dibuja los copos en la pantalla
function dibujaCopo(x, y){
    var formaCopos = new Array("❆","❅","❄");
    var posFormaCopo = Math.floor(Math.random()*formaCopos.length);

    var tamano = Math.floor(Math.random()*4)+1;

    var elementoDiv = document.createElement("div");
        elementoDiv.setAttribute("class", "copo copo"+tamano);
        elementoDiv.style.left = x+"px";
        elementoDiv.style.top = y+"px";
    var contenidoDiv = document.createTextNode(formaCopos[posFormaCopo]);
    
    elementoDiv.appendChild(contenidoDiv);
    document.body.appendChild(elementoDiv);
    return elementoDiv;
}

// Función que controla el movimiento de los copos por la pantalla
function nevar(copos, alturaMax){
    var anchuraActual = window.innerWidth;
    var i, x, y;
    for (i = 0; i < copos.length; i++){
        x = parseInt(copos[i].style.left);
        //Si no se sale de la pantalla
        if(x <= anchuraActual){
            y = parseInt(copos[i].style.top);

            x += parseInt((Math.random()*3))-1;
            y += Math.floor(Math.random()*4)+1;

            copos[i].style.top = y+"px";
            copos[i].style.left = x+"px";

            //Si ha llegado al final de la pantalla
            if(y>alturaMax){
                // posicionamos nuevamente en la parte superior
                copos[i].style.top = -20+"px";
                // cogemos una posicion horizontal aleatoria
                copos[i].style.left=parseInt((Math.random()*anchuraActual)+1) + "px";
            }
        }
    }
}