var fuerzaViento = 0;
window.addEventListener('load', onLoad, true);

function onLoad(){
    inicializarNieve(100);
}

function inicializarNieve(velocidad){
    var i, x, y;
    var anchuraMax=window.screen.availWidth;
    var alturaMax=window.screen.availHeight;
    var numeroCopos = parseInt(anchuraMax / 40 + alturaMax / 40);
    var divPadre = document.createElement("div");
    	divPadre.setAttribute("id", "ventisca");
    var copos = new Array(numeroCopos);
    for (i = 0; i<numeroCopos; i++){
        x = parseInt(Math.random()*anchuraMax);
        y = parseInt(Math.random()*alturaMax) - 20;
        copos[i] = dibujaCopo(x,y, divPadre);
    }
    document.body.appendChild(divPadre);

    cambiarFuerzaViento();
    setInterval(nevar, velocidad, copos, alturaMax, anchuraMax);
}
// Función inicial que dibuja los copos en la pantalla
function dibujaCopo(x, y, padre){
    var formaCopos = new Array("❆","❅","❄");
    var posFormaCopo = Math.floor(Math.random()*formaCopos.length);

    var tamano = Math.floor(Math.random()*4)+1;

    var elementoDiv = document.createElement("div");
        elementoDiv.setAttribute("class", "copo copo"+tamano);
        elementoDiv.style.left = x+"px";
        elementoDiv.style.top = y+"px";
    var contenidoDiv = document.createTextNode(formaCopos[posFormaCopo]);
    
    elementoDiv.appendChild(contenidoDiv);
    padre.appendChild(elementoDiv);
    return elementoDiv;
}

//Cambia la fuerza del viento
function cambiarFuerzaViento(){
	if(fuerzaViento >= 2){
		fuerzaViento += -1;
	}else if(fuerzaViento <= -2){
		fuerzaViento += 1;
	}else{
		fuerzaViento += parseInt((Math.random()*3))-1
	}

	setTimeout(cambiarFuerzaViento, parseInt((Math.random()*5000))+10000)
}

// Función que controla el movimiento de los copos por la pantalla
function nevar(copos, alturaMax, anchuraMax){
    var i, x, y;
    for (i = 0; i < copos.length; i++){
        y = parseInt(copos[i].style.top);
        y += Math.floor(Math.random()*4)+1; //1, 2, 3, 4
        //Si ha llegado al final de la pantalla
        if(y>alturaMax){
            // posicionamos nuevamente en la parte superior
            copos[i].style.top = -20+"px";
            // cogemos una posicion horizontal aleatoria
            copos[i].style.left=parseInt((Math.random()*anchuraMax)+1) + "px";
        }else{
        	copos[i].style.top = y+"px";

        	x = parseInt(copos[i].style.left);

        	//Si no se sale de la pantalla
	        if(x >= 0 && x <= anchuraMax){
	            x += parseInt((Math.random()*3))-1; //-1, 0, 1
	            x += fuerzaViento;
	            copos[i].style.left = x+"px";

	        }else if(fuerzaViento > 0 && x > anchuraMax){ //Si se sale por la derecha
	        	copos[i].style.left = "0px";
	        }else if(fuerzaViento < 0 && x < 0){ //Si se sale por la izquierda
	        	copos[i].style.left = anchuraMax+"px";
	        }
        }
    }
}