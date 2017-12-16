//@Nombre: nieve.js
//@Fecha de creación: 1-12-2017
//@Creador: Marc Colominas Rojas
//@Descipción: Genera nieve que cae en la pagina web

//Contiene la fuerza que tiene el viento
var fuerzaViento = 0;

//Llamar a la funcion onLoad cuando se carge la pagina
window.addEventListener('load', onLoad, true);

//@Descripción: Funcion que se llama al cargar la pagina.
//@Params: Ninguno
//@Return: Ninguno
function onLoad(){
    inicializarNieve(100);
}

//@Descripción: Inicializa la nevada, se le pasa la velocidad en que caera la nieve
//@Params: velocidad (Integer)
//@Return: Ninguno
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

//@Descripción: Función inicial que dibuja los copos en la pantalla, se le pasa la posicion del copo y su padre para meterlos dentro y devuelve el copo creado
//@Params: x (Integer), y (Integer), padre (Dom Element)
//@Return: Dom Element 
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

//@Descripción: Cambia la fuerza del viento
//@Params: Ninguno
//@Return: Ninguno 
function cambiarFuerzaViento(){
	if(fuerzaViento >= 4){
		fuerzaViento += -1;
	}else if(fuerzaViento <= -4){
		fuerzaViento += 1;
	}else{
		fuerzaViento += parseInt((Math.random()*3))-1
	}
	setTimeout(cambiarFuerzaViento, parseInt((Math.random()*5000))+10000)
}

//@Descripción: Controla el movimiento de los copos por la pantalla, se le pasa el array que contiene los copos, y la altura y anchura de la pantalla
//@Params: copos (dom element[]), alturaMax (Integer), anchuraMax (Integer)
//@Return: Ninguno 
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

	        if(x > anchuraMax){ //Si se sale por la derecha
	        	copos[i].style.left = "0px";
	        }else if(x <= -20){ //Si se sale por la izquierda
	        	copos[i].style.left = anchuraMax+"px";
	        }else{ //Si no se sale de la pantalla
	        	x += parseInt((Math.random()*3))-1; //-1, 0, 1
	            x += fuerzaViento;
	            copos[i].style.left = x+"px";
	        }
        }
    }
}