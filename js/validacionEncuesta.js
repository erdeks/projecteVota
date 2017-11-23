var error = null;
function inicializar(){
	error = null;
	document.getElementById('pregunta').addEventListener("input", checkInputPreguntaTextoCambia);
	document.getElementById('pregunta').addEventListener("blur", checkInputPreguntaFocoPerdido);
	document.getElementById('addRespuesta').addEventListener("click", addRespuesta);
	document.getElementById('removeRespuesta').addEventListener("click", eliminarTodasRespuestas);

	//Input fechas
	var fechasInicio = document.getElementById("dataInicio").children;
	for(var i = 0; i < fechasInicio.length; i++){
		fechasInicio[i].getElementsByTagName("input")[0].addEventListener("input", checkFechaInicioTextoCambia);
		fechasInicio[i].getElementsByTagName("input")[0].addEventListener("blur", checkFechaInicioFocoPerdido);
	}
	var fechasFin = document.getElementById("dataFin").children;
	for(var i = 0; i < fechasFin.length; i++){
		fechasFin[i].getElementsByTagName("input")[0].addEventListener("input", checkFechaFinTextoCambia);
		fechasFin[i].getElementsByTagName("input")[0].addEventListener("blur", checkFechaFinFocoPerdido);
	}

	addRespuesta();
	addRespuesta();
}
//Chequear
function checkBtnCrearFormulario(){
	var btnCrearFormulario = document.getElementById('crearForumario');
	var inputPregunta = document.getElementById('pregunta');

	if(isVacio(inputPregunta) || getCantRespuestas() < 2 || isRespuestaVacia() || isDataInicioVacia() || isDataFinVacia()){
		desactivarInput(btnCrearFormulario);
	}else{
		activarInput(btnCrearFormulario);
	}
}
function checkBtnAgregarRespuestas(){
	var btnAddRespuesta = document.getElementById('addRespuesta');
	
	if(isRespuestaVacia()){
		desactivarInput(btnAddRespuesta);
	}else{
		activarInput(btnAddRespuesta);
	}
}
function checkInputPreguntaTextoCambia(){
	if(error != null){
		desactivarMensajeError(error);
	}
	if(!isVacio(this)){
		eliminarError(this);
	}
	checkBtnCrearFormulario();
	checkBtnAgregarRespuestas();
}
function checkInputPreguntaFocoPerdido(){
	if(isVacio(this)){
		crearError(this, "La pregunta no puede estar vacia.");
	}
}
function checkInputsRespuestasTextoCambia(){
	if(error != null){
		desactivarMensajeError(error);
	}
	if(!isVacio(this)){
		eliminarError(this);
	}
	checkBtnCrearFormulario();
	checkBtnAgregarRespuestas();
}
function checkInputsRespuestasFocoPerdido(){
	if(isVacio(this)){
		crearError(this, "La respuesta no puede estar vacia.");
	}
}
function checkFechaInicioTextoCambia(){
	switch(this.getAttribute("id")){
		case "diaInicio":
		break;
		case "mesInicio":
		break;
		case "anyInicio":
		break;
	}
	checkBtnCrearFormulario();
}
function checkFechaInicioFocoPerdido(){
	//alert(daysInMonth(12,2007))
	switch(this.getAttribute("id")){
		case "diaInicio":
			if(isVacio(this)){
				crearError(this, "EL dia no puede estar vacio");
			}
		break;
		case "mesInicio":
			if(isVacio(this)){
				crearError(this, "EL mes no puede estar vacio");
			}
		break;
		case "anyInicio":
			if(isVacio(this)){
				crearError(this, "EL año no puede estar vacio");
			}
		break;
	}
	checkBtnCrearFormulario();
	
}
function checkFechaFinTextoCambia(){
	switch(this.getAttribute("id")){
		case "diaFin":
		break;
		case "mesFin":
		break;
		case "anyFin":
		break;
	}
	checkBtnCrearFormulario();
}
function checkFechaFinFocoPerdido(){
	switch(this.getAttribute("id")){
		case "diaFin":
		break;
		case "mesFin":
		break;
		case "anyFin":
		break;
	}
	checkBtnCrearFormulario();
}
//Fin chequear
//Manejar respuestas
function getCantRespuestas(){
	return document.getElementById("respuestas").children.length;
}

function isRespuestaVacia(){
	var respuestas = document.getElementById("respuestas");
	for (var i = 0; i < getCantRespuestas(); i++) {
		var input = respuestas.children[i].getElementsByTagName('input')[0];
		if(isVacio(input)){
			return true;
		}
	}
	return false;
}

function addRespuesta(){
	var padre = document.getElementById('respuestas');

	var elementoDiv = document.createElement("div");
	var elementoSpan = document.createElement("span");
	var textoSpan = document.createTextNode("Respuesta " + (getCantRespuestas() + 1));
	agregarHijo(elementoSpan, textoSpan);
	agregarHijo(elementoDiv, elementoSpan);


	var elementoDivError = document.createElement("div");
	elementoDivError.setAttribute("class", "tooltip");
	agregarHijo(elementoDiv, elementoDivError);

	var elementoInput = document.createElement("input");
	elementoInput.setAttribute("type", "text");
	elementoInput.setAttribute("type", "res" + (getCantRespuestas() + 1));
	elementoInput.addEventListener("input", checkInputsRespuestasTextoCambia);
	elementoInput.addEventListener("blur", checkInputsRespuestasFocoPerdido);
	agregarHijo(elementoDivError, elementoInput);

	agregarHijo(padre, elementoDiv);

	checkBtnCrearFormulario();
	checkBtnAgregarRespuestas();
}

function eliminarTodasRespuestas(){
	var padre = document.getElementById('respuestas');
	var hijos = padre.children;
	for(var i = hijos.length - 1; i >= 0; i--){
		eliminarHijo(padre, hijos[i]);
	}

	checkBtnAgregarRespuestas();
	checkBtnCrearFormulario();

	addRespuesta();
	addRespuesta();

}
//Fin manejar respuestas
//Manejar datas
function daysInMonth(month,year) {
    return new Date(year, month, 0).getDate();
}
function isDataInicioVacia(){
	var datasInicio = document.getElementById("dataInicio").children;
	for (var i = 0; i < datasInicio.length; i++) {
		var input = datasInicio[i].getElementsByTagName('input')[0];
		if(isVacio(input)){
			return true;
		}
	}
	return false;
}
function isDataFinVacia(){
	var datasFin = document.getElementById("dataFin").children;
	for (var i = 0; i < datasFin.length; i++) {
		var input = datasFin[i].getElementsByTagName('input')[0];
		if(isVacio(input)){
			return true;
		}
	}
	return false;
}
//Fin manejar datas
//Errores
function crearError(input, mensaje = "") {
	var errorActivo = isErrorActivo(input);
	if(!errorActivo){
		mostrarMensajeError(input);

		input.style.boxShadow = "0 0 5px red";
		input.style.border = "1px solid red";
		input.style.outline = "none";
		var padre = input.parentNode;

		var elementoSpan = document.createElement("span");
		elementoSpan.setAttribute("class", "tooltiptext");

		var textoSpan = document.createTextNode(mensaje);
		agregarHijo(elementoSpan, textoSpan);
		insertarDespues(padre, input, elementoSpan);
		
		if(error != null && error != input){
			desactivarMensajeError(error);
		}
		error = input;
	}else{
		if(error != null && error != input){
			desactivarMensajeError(error);
		}
		mostrarMensajeError(input);
		error = input;
	}
}
function eliminarError(input){
	if(isErrorActivo(input)){
		input.style.boxShadow = "";
		input.style.border = "";
		input.style.outline = "";
		eliminarHijo(input.parentNode, getSiguienteElemento(input));
	}
}
function desactivarMensajeError(input){
	error = null;
	var siguienteElemento = getSiguienteElemento(input);
	if(siguienteElemento != null){
		siguienteElemento.style.display = "none";
	}
}
function mostrarMensajeError(input){
	var siguienteElemento = getSiguienteElemento(input);
	if(siguienteElemento != null){
		siguienteElemento.style.display = "";
	}
}
function isErrorActivo(input){
	var siguienteElemento = getSiguienteElemento(input);
	return siguienteElemento != null && siguienteElemento.getAttribute("class") == "tooltiptext";
}
//Fin de errores
//JS DOM
function agregarHijo(padre, hijo){
	padre.appendChild(hijo);
}
function insertarAntes(padre, hijo, elemento){
	padre.insertBefore(elemento, hijo);
}
function moverHijo(padre, hijo, destino){
	var clon = hijo.cloneNode(true);
	agregarHijo(destino, clon);
	eliminarHijo(padre, hijo);
}
function eliminarHijo(padre, hijo){
	padre.removeChild(hijo);
}

function insertarDespues(padre, hijo, elemento){
	if(getSiguienteElemento(hijo)){ 
		insertarAntes(padre, getSiguienteElemento(hijo), elemento);
	}else{
		agregarHijo(padre, elemento);
	}
}
function getSiguienteElemento(hijo){
	return hijo.nextSibling;
}

//Fin JS DOM
//Funciones inputs
function desactivarInput(input){
	if(!isActivoInput(input))
		input.disabled = true;
}
function activarInput(input){
	if(isActivoInput(input))
		input.disabled = false;
}
function isActivoInput(input) {
	return input.disabled == true;
}
function isVacio(input){
	return input.value == "";
}
//Fin funciones inputs
//General

//Fin General