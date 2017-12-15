//@Nombre: animacionPreguntas.js
//@Fecha de creación: 1-12-2017
//@Creador: Marc Colominas Rojas
//@Descipción: Realiza una animacion que se realiza 1 vez para mostrar de forma deslizante

//Llamar a la funcion onLoad cuando se carge la pagina
window.addEventListener('load', onLoad, true);

//@Descripción: Funcion que se llama al cargar la pagina.
//@Params: Ninguno
//@Return: Ninguno
function onLoad(){
    var elementForm = document.getElementsByClassName('animacionDesplegar')[0];
    if(elementForm != null) animacionAdd(elementForm);
}

//@Descripción: Genera la animacion para mostrar el contenido de forma despizante, de le pasa el objeto dom que realizara la animacion
//@Params: padre (objeto Dom)
//@Return: Ninguno
function animacionAdd(padre) {
	padre.style.overflow = "hidden";
	var totalHeight = padre.offsetHeight;
	padre.style.height = "0px";
	var height = 0;
	var interval_id = setInterval(frame, 15);
	function frame() {
		if (height >= totalHeight) {
			padre.removeAttribute("style");
			clearInterval(interval_id);
		} else {
			height++;
			padre.style.height = height + 'px';
		}
	}
}