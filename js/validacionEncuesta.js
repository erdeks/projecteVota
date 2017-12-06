var error = null;
var interval_id_validacionEncuesta = -1;

window.addEventListener('load', onLoad, true);

function onLoad(){
    document.getElementById("generarForm").addEventListener("click", generarForumario);
}

//Inicio crear Formulario
//Generar Formulario
function generarForumario(){
	this.disabled = true;
	this.removeEventListener("click", generarForumario);

	var elementoFechaInicio = getElementoFechaInicio();
	var elementoFechaFin = getElementoFechaFin();
	var elementoPregunta = getElementoPregunta();
	var elementoDescripcion = getElementoDescripcion();
	var elementoMultirespuesta = getElementoMultirespuesta();
	var elementoBotones = getElementoBotones();
	var elementoRespuestas = getElementoRespuestas();

	elementoForm = document.createElement("form");
	elementoForm.setAttribute("method", "post");
	elementoForm.setAttribute("action", "../php/crearEncuesta.php");

	agregarHijo(elementoForm, elementoFechaInicio);
	agregarHijo(elementoForm, elementoFechaFin);
	agregarHijo(elementoForm, elementoPregunta);
	agregarHijo(elementoForm, elementoDescripcion);
	agregarHijo(elementoForm, elementoMultirespuesta);
	agregarHijo(elementoForm, elementoBotones);
	agregarHijo(elementoForm, elementoRespuestas);
	agregarHijo(this.parentNode, elementoForm);

	checkBtnAgregarRespuestas();
	checkBtnCrearFormulario();
}
//Obtener fecha inicio
function getElementoFechaInicio(){
	var elementoDiv = document.createElement("div");
		elementoDiv.setAttribute("id", "dataInicio");

	var elementoLavel = document.createElement("lavel");
		contenidoLavel = document.createTextNode("Fecha de inicio:");

	var elementoBr = document.createElement("br");

	var elementoDivErrorDia = document.createElement("div");
		elementoDivErrorDia.setAttribute("class", "tooltip");

	var elementoDivErrorMes = document.createElement("div");
		elementoDivErrorMes.setAttribute("class", "tooltip");

	var elementoDivErrorAny = document.createElement("div");
		elementoDivErrorAny.setAttribute("class", "tooltip");

	var elementoInputDia = document.createElement("input");
		elementoInputDia.setAttribute("type", "number");
		elementoInputDia.setAttribute("name", "diaInicio");
		elementoInputDia.setAttribute("placeholder", "DD");
		elementoInputDia.required = true;

	var elementoInputMes = document.createElement("input");
		elementoInputMes.setAttribute("type", "number");
		elementoInputMes.setAttribute("name", "mesInicio");
		elementoInputMes.setAttribute("placeholder", "MM");
		elementoInputMes.required = true;

	var elementoInputAny = document.createElement("input");
		elementoInputAny.setAttribute("type", "number");
		elementoInputAny.setAttribute("name", "anyInicio");
		elementoInputAny.setAttribute("placeholder", "YYYY");
		elementoInputAny.required = true;

	agregarHijo(elementoDiv, elementoLavel);
	agregarHijo(elementoLavel, contenidoLavel);
	agregarHijo(elementoDiv, elementoBr);
	agregarHijo(elementoDiv, elementoDivErrorDia);
	agregarHijo(elementoDiv, elementoDivErrorMes);
	agregarHijo(elementoDiv, elementoDivErrorAny);
	agregarHijo(elementoDivErrorDia, elementoInputDia);
	agregarHijo(elementoDivErrorMes, elementoInputMes);
	agregarHijo(elementoDivErrorAny, elementoInputAny);

	//Eventos
	elementoInputDia.addEventListener("input", checkFechaInicio);
	elementoInputDia.addEventListener("blur", checkFechaInicio);
	elementoInputMes.addEventListener("input", checkFechaInicio);
	elementoInputMes.addEventListener("blur", checkFechaInicio);
	elementoInputAny.addEventListener("input", checkFechaInicio);
	elementoInputAny.addEventListener("blur", checkFechaInicio);

	return elementoDiv;
}
//Obtener fecha fin
function getElementoFechaFin(){
	var elementoDiv = document.createElement("div");
		elementoDiv.setAttribute("id", "dataFin");

	var elementoLavel = document.createElement("lavel");
		contenidoLavel = document.createTextNode("Fecha de cierre:");

	var elementoBr = document.createElement("br");

	var elementoDivErrorDia = document.createElement("div");
		elementoDivErrorDia.setAttribute("class", "tooltip");

	var elementoDivErrorMes = document.createElement("div");
		elementoDivErrorMes.setAttribute("class", "tooltip");

	var elementoDivErrorAny = document.createElement("div");
		elementoDivErrorAny.setAttribute("class", "tooltip");

	var elementoInputDia = document.createElement("input");
		elementoInputDia.setAttribute("type", "number");
		elementoInputDia.setAttribute("name", "diaFin");
		elementoInputDia.setAttribute("placeholder", "DD");
		elementoInputDia.required = true;

	var elementoInputMes = document.createElement("input");
		elementoInputMes.setAttribute("type", "number");
		elementoInputMes.setAttribute("name", "mesFin");
		elementoInputMes.setAttribute("placeholder", "MM");
		elementoInputMes.required = true;

	var elementoInputAny = document.createElement("input");
		elementoInputAny.setAttribute("type", "number");
		elementoInputAny.setAttribute("name", "anyFin");
		elementoInputAny.setAttribute("placeholder", "YYYY");
		elementoInputAny.setAttribute("placeholder", "YYYY");
		elementoInputAny.required = true;

	agregarHijo(elementoDiv, elementoLavel);
	agregarHijo(elementoLavel, contenidoLavel);
	agregarHijo(elementoDiv, elementoBr);
	agregarHijo(elementoDiv, elementoDivErrorDia);
	agregarHijo(elementoDiv, elementoDivErrorMes);
	agregarHijo(elementoDiv, elementoDivErrorAny);
	agregarHijo(elementoDivErrorDia, elementoInputDia);
	agregarHijo(elementoDivErrorMes, elementoInputMes);
	agregarHijo(elementoDivErrorAny, elementoInputAny);

	//Eventos
	elementoInputDia.addEventListener("input", checkFechaFin);
	elementoInputDia.addEventListener("blur", checkFechaFin);
	elementoInputMes.addEventListener("input", checkFechaFin);
	elementoInputMes.addEventListener("blur", checkFechaFin);
	elementoInputAny.addEventListener("input", checkFechaFin);
	elementoInputAny.addEventListener("blur", checkFechaFin);

	return elementoDiv;
}
//Obtener el elemento pregunta
function getElementoPregunta(){
	var elementoDiv = document.createElement("div");

	var elementoLavel = document.createElement("lavel");
		contenidoLavel = document.createTextNode("Pregunta:");

	var elementoBr = document.createElement("br");

	var elementoDivError = document.createElement("div");
		elementoDivError.setAttribute("class", "tooltip");

	var elementoInput = document.createElement("input");
		elementoInput.setAttribute("id", "pregunta");
		elementoInput.setAttribute("type", "input");
		elementoInput.setAttribute("name", "pregunta");
		elementoInput.required = true;

	agregarHijo(elementoDiv, elementoLavel);
	agregarHijo(elementoLavel, contenidoLavel);
	agregarHijo(elementoDiv, elementoBr);
	agregarHijo(elementoDiv, elementoDivError);
	agregarHijo(elementoDivError, elementoInput);

	//Eventos
	elementoInput.addEventListener("input", checkInputPreguntaTextoCambia);
	elementoInput.addEventListener("blur", checkInputPreguntaFocoPerdido);

	return elementoDiv;
}
//Obtener el elemento descripcion
function getElementoDescripcion(){
	var elementoDiv = document.createElement("div");

	var elementoLavel = document.createElement("lavel");
	var contenidoLavel = document.createTextNode("Descripción (opcional):");

	var elementoBr = document.createElement("br");

	var elementoInput = document.createElement("input");
		elementoInput.setAttribute("type", "input");
		elementoInput.setAttribute("name", "descripcion");

	agregarHijo(elementoDiv, elementoLavel);
	agregarHijo(elementoLavel, contenidoLavel);
	agregarHijo(elementoDiv, elementoBr);
	agregarHijo(elementoDiv, elementoInput);

	return elementoDiv;
}
//Obtener el elemento multirespuesta
function getElementoMultirespuesta(){
	var elementoDiv = document.createElement("div");

	var elementoDiv2 = document.createElement("div");
	var contenidoDiv2 = document.createTextNode("Multirespuesta?");

	var elementoLabelSi = document.createElement("label");
		elementoLabelSi.setAttribute("for", "multiSi");
	var contenidoLabelSi = document.createTextNode("Si ");

	var elementoLabelNo = document.createElement("label");
		elementoLabelNo.setAttribute("for", "multiNo");
	var contenidoLabelNo = document.createTextNode("No ");

	var elementoInputSi = document.createElement("input");
		elementoInputSi.setAttribute("id", "multiSi");
		elementoInputSi.setAttribute("type", "radio");
		elementoInputSi.setAttribute("name", "multirespuesta");
		elementoInputSi.setAttribute("value", "si");

	var elementoInputNo = document.createElement("input");
		elementoInputNo.setAttribute("id", "multiNo");
		elementoInputNo.setAttribute("type", "radio");
		elementoInputNo.setAttribute("name", "multirespuesta");
		elementoInputNo.setAttribute("value", "no");
		elementoInputNo.checked = true;

	agregarHijo(elementoDiv2, contenidoDiv2);
	agregarHijo(elementoLabelSi, contenidoLabelSi);
	agregarHijo(elementoLabelNo, contenidoLabelNo);
	agregarHijo(elementoDiv, elementoDiv2);
	agregarHijo(elementoDiv, elementoLabelSi);
	agregarHijo(elementoDiv, elementoInputSi);
	agregarHijo(elementoDiv, elementoLabelNo);
	agregarHijo(elementoDiv, elementoInputNo);

	return elementoDiv;
}
//Obtener el elemento botones
function getElementoBotones(){
	var elementoDiv = document.createElement("div");

	var elementoInput = document.createElement("input");
		elementoInput.setAttribute("id", "crearForumario");
		elementoInput.setAttribute("type", "submit");
		elementoInput.setAttribute("value", "Enviar");

	var elementoButtonAddRespuesta = document.createElement("button");
		elementoButtonAddRespuesta.setAttribute("id", "addRespuesta");
		elementoButtonAddRespuesta.setAttribute("type", "button");

	var contenidoButtonAddRespuesta = document.createTextNode("Crear otra respuesta");

	var elementoButtonDelRespuestas = document.createElement("button");
		elementoButtonDelRespuestas.setAttribute("id", "removeRespuesta");
		elementoButtonDelRespuestas.setAttribute("type", "button");

	var contenidoButtonDelRespuestas = document.createTextNode("Eliminar todas las respuestas");

	agregarHijo(elementoDiv, elementoInput);
	agregarHijo(elementoDiv, elementoButtonAddRespuesta);
	agregarHijo(elementoButtonAddRespuesta, contenidoButtonAddRespuesta);
	agregarHijo(elementoDiv, elementoButtonDelRespuestas);
	agregarHijo(elementoButtonDelRespuestas, contenidoButtonDelRespuestas);

	//Eventos
	elementoButtonAddRespuesta.addEventListener("click", addRespuesta);
	elementoButtonDelRespuestas.addEventListener("click", eliminarTodasRespuestas);

	return elementoDiv;
}

//Obtener el elemento respuestas (donde se almacenaran las respuestas)
function getElementoRespuestas(){
	var elementoDiv = document.createElement("div");
		elementoDiv.setAttribute("id", "respuestas");

	return elementoDiv;
}
//Fin crear Formulario
//Chequear
//Activa o desactivar el boton para enviar el formulario
function checkBtnCrearFormulario(){
	var btnCrearFormulario = document.getElementById('crearForumario');
	var inputPregunta = document.getElementById('pregunta');

	if(isVacio(inputPregunta) || getCantRespuestas() < 2 || isRespuestaVacia() || !isValidoFechaInicio() || !isValidoFechaFin()){
		desactivarInput(btnCrearFormulario);
	}else{
		activarInput(btnCrearFormulario);
	}
}
//Activa o desactivar el boton para añadir mas respuestas
function checkBtnAgregarRespuestas(){
	var btnAddRespuesta = document.getElementById('addRespuesta');
	var cantRespuestas = getCantRespuestas();
	if(cantRespuestas == 0) btnAddRespuesta.textContent = "Añadir una respuesta";
	else if(cantRespuestas == 1) btnAddRespuesta.textContent = "Añadir otra respuesta";
	if(isRespuestaVacia()){
		desactivarInput(btnAddRespuesta);
	}else{
		activarInput(btnAddRespuesta);
	}
}
//Checkear el estado del input pregunta cuando el texto se esta cambiando
function checkInputPreguntaTextoCambia(){
	if(error != null){
		desactivarMensajeError(error);
	}
	if(!isVacio(this)){
		eliminarError(this);
	}
	checkBtnCrearFormulario();
}
//Checkear el estado del input pregunta cuando se pierde el foco
function checkInputPreguntaFocoPerdido(){
	if(isVacio(this)){
		crearError(this, "La pregunta no puede estar vacia.");
	}
}
//Checkear el estado del input respuestas cuando el texto se esta cambiando
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
//Checkear el estado del input respuestas cuando se pierde el foco
function checkInputsRespuestasFocoPerdido(){
	if(isVacio(this)){
		crearError(this, "La respuesta no puede estar vacia.");
	}
}
//Checkear el dia, mes y año de la fecha de inicio
//Se accede cuando el texto cambia o se pierde el foco
function checkFechaInicio(){
	if(error != null){
		desactivarMensajeError(error);
	}

	desactivarErroresFechaFin();
	activarErroresFechaFin();

	desactivarErroresFechaInicio(this);
	activarErroresFechaInicio(this);

	checkBtnCrearFormulario();
}
//Checkear el dia, mes y año de la fecha de fin
//Se accede cuando el texto cambia o se pierde el foco
function checkFechaFin(){
	if(error != null){
		desactivarMensajeError(error);
	}

	desactivarErroresFechaInicio();
	activarErroresFechaInicio();
	
	desactivarErroresFechaFin(this);
	activarErroresFechaFin(this);
	
	checkBtnCrearFormulario();
}
//Funcion que comprueba si desactiva los errores de la fecha de inicio
function desactivarErroresFechaInicio(inputActual = null){
	var padre = document.getElementById("dataInicio");
	var inputDia = getInputDia(padre);
	var inputMes = getInputMes(padre);
	var inputAny = getInputAny(padre);
	var dia = inputDia.value;
	var mes = inputMes.value;
	var any = inputAny.value;
	var isFechaCompleta = (dia != "" && mes != "" && any != "");

	var fechaActual = getFechaReseteada();
	var fechaInicio = null;

	if(isFechaCompleta) fechaInicio = getFechaReseteada(any, mes, dia);
	
	if(isFechaCompleta && fechaInicio >= fechaActual){
		if(dia > 0 && dia <= daysInMonth(any, mes))
			eliminarError(inputDia);
		if(mes > 0 && mes < 13)
			eliminarError(inputMes);
		eliminarError(inputAny);
	}else if(inputActual != null && !isVacio(inputActual)){
		eliminarError(inputActual);
	}
}
//Funcion que comprueba si activa los errores de la fecha de inicio
function activarErroresFechaInicio(inputActual = null){
	var padre = document.getElementById("dataInicio");
	var inputDia = getInputDia(padre);
	var inputMes = getInputMes(padre);
	var inputAny = getInputAny(padre);
	var dia = inputDia.value;
	var mes = inputMes.value;
	var any = inputAny.value;
	var error = false;
	if(inputActual != null){
		switch(getPosition(inputActual.parentNode)){
			case getPosition(getInputDia(padre).parentNode): //Dia
				if(dia == ""){
					crearError(inputDia, "EL dia no puede estar vacio.");
				}else if(dia <= 0){
					crearError(inputDia, "El dia no puede ser menor de 1.");
					error = true;
				}
				break;
			case getPosition(getInputMes(padre).parentNode): //Mes
				if(mes == ""){
					crearError(inputMes, "EL mes no puede estar vacio.");
				}else if(mes <= 0 || mes > 12){
					crearError(inputMes, "No existe el mes.");
					error = true;
				}
				break;
			case getPosition(getInputAny(padre).parentNode): //Año
				if(any == ""){
					crearError(inputAny, "EL año no puede estar vacio.");
				}
				break;
		}
	}
	if(!error){
		var isFechaCompleta = (dia != "" && mes != "" && any != "");
		
		var fechaActual = getFechaReseteada();
		var fechaInicio = null;

		if(isFechaCompleta) fechaInicio = getFechaReseteada(any, mes, dia);

		if(isFechaCompleta && dia > daysInMonth(mes, any)){
			crearError(inputDia, "El mes seleccionado solo tiene "+daysInMonth(mes, any)+" dias.");
		}else if(isFechaCompleta && fechaInicio < fechaActual){
			crearError(inputDia, "");
			crearError(inputAny, "");
			crearError(inputMes, "La fecha de inicio no puede ser menor a la fecha actual");
		}
	}
}
//Funcion que comprueba si desactiva los errores de la fecha de fin
function desactivarErroresFechaFin(inputActual = null){
	var padre = document.getElementById("dataFin");
	var inputDia = getInputDia(padre);
	var inputMes = getInputMes(padre);
	var inputAny = getInputAny(padre);
	var dia = inputDia.value;
	var mes = inputMes.value;
	var any = inputAny.value;

	var isFechaCompleta = (dia != "" && mes != "" && any != "");

	var fechaInicio = getFechaInicio();
	var fechaFin = null;

	if(isFechaCompleta) fechaFin = getFechaReseteada(any, mes, dia);

	if(fechaInicio != false) fechaInicio = addDias(fechaInicio, 1);
	
	if(isFechaCompleta && fechaInicio != false && fechaFin >= fechaInicio){
		if(dia > 0 && dia <= daysInMonth(any, mes))
			eliminarError(inputDia);
		if(mes > 0 && mes < 13)
			eliminarError(inputMes);
		eliminarError(inputAny);
	}else if(inputActual != null && !isVacio(inputActual)){
		eliminarError(inputActual);
	}
}
//Funcion que comprueba si activa los errores de la fecha de fin
function activarErroresFechaFin(inputActual = null){
	var padre = document.getElementById("dataFin");
	var inputDia = getInputDia(padre);
	var inputMes = getInputMes(padre);
	var inputAny = getInputAny(padre);
	var dia = inputDia.value;
	var mes = inputMes.value;
	var any = inputAny.value;
	var error = false;

	if(inputActual != null){
		switch(getPosition(inputActual.parentNode)){
			case getPosition(getInputDia(padre).parentNode): //Dia
				if(dia == ""){
					crearError(inputDia, "EL dia no puede estar vacio.");
				}else if(dia <= 0){
					crearError(inputDia, "El dia no puede ser menor de 1.");
					error = true;
				}
				break;
			case getPosition(getInputMes(padre).parentNode): //Mes
				if(mes == ""){
					crearError(inputMes, "EL mes no puede estar vacio.");
				}else if(mes <= 0 || mes > 12){
					crearError(inputMes, "No existe el mes.");
					error = true;
				}
				break;
			case getPosition(getInputAny(padre).parentNode): //Año
				if(any == ""){
					crearError(inputAny, "EL año no puede estar vacio.");
				}
				break;
		}
	}
	if(!error){
		var isFechaCompleta = (dia != "" && mes != "" && any != "");

		var fechaInicio = getFechaInicio();
		var fechaFin = null;
		if(isFechaCompleta) fechaFin = getFechaReseteada(any, mes, dia);

		if(fechaInicio != false) fechaInicio = addDias(fechaInicio, 1);

		
		
		if(isFechaCompleta && dia > daysInMonth(mes, any)){
			crearError(inputDia, "El mes seleccionado solo tiene "+daysInMonth(mes, any)+" dias.");
		}else if(isFechaCompleta && fechaInicio != false && fechaFin < fechaInicio){
			crearError(inputDia, "");
			crearError(inputAny, "");
			crearError(inputMes, "La fecha de cierre tiene que tener 1 dia de diferencia.");
		}
	}
}
//Fin chequear
//Manejar respuestas
//Obtener cuantas respuestas se han creado
function getCantRespuestas(){
	return document.getElementById("respuestas").children.length;
}
//Debuelve true si hay alguna vacia, false si todas estan llenas
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

//Añadir una nueva respuesta
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
	elementoInput.setAttribute("name", "res" + (getCantRespuestas() + 1));
	elementoInput.addEventListener("input", checkInputsRespuestasTextoCambia);
	elementoInput.addEventListener("blur", checkInputsRespuestasFocoPerdido);
	agregarHijo(elementoDivError, elementoInput);

	agregarHijo(elementoDiv, getButtonUp());
	agregarHijo(elementoDiv, getButtonDown());
	agregarHijo(elementoDiv, getButtonRemove());

	agregarHijo(padre, elementoDiv);
	animacionAdd(padre, elementoDiv);

	checkBtnCrearFormulario();
	checkBtnAgregarRespuestas();
	checkBotonesRespuesta(padre);
}
//Obtener el boton hacia arriba
function getButtonUp(){
	var elementoButton = document.createElement("button");
		elementoButton.setAttribute("type", "button")
	var elementoI = document.createElement("i");
		elementoI.setAttribute("class", "fa fa-arrow-up");

	agregarHijo(elementoButton, elementoI);

	elementoButton.addEventListener("click", moverRespuestaArriba);

	return elementoButton;
}
//Obtener el boton hacia abajo
function getButtonDown(){
	var elementoButton = document.createElement("button");
		elementoButton.setAttribute("type", "button")
	var elementoI = document.createElement("i");
		elementoI.setAttribute("class", "fa fa-arrow-down");

	agregarHijo(elementoButton, elementoI);

	elementoButton.addEventListener("click", moverRespuestaAbajo);
	
	return elementoButton;
}
//Obtener el boton eliminar
function getButtonRemove(){
	var elementoButton = document.createElement("button");
		elementoButton.setAttribute("type", "button")
	var elementoI = document.createElement("i");
		elementoI.setAttribute("class", "fa fa-trash-o");

	agregarHijo(elementoButton, elementoI);

	elementoButton.addEventListener("click", eliminarRespuesta);
	
	return elementoButton;
}
//Elimina todas las respuestas
function eliminarTodasRespuestas(){
	var padre = document.getElementById('respuestas');

	animacionDelAll(padre);
}
//Funcion para cambiar el value del input del evento por el value del input superior
function moverRespuestaArriba(){
	var esteElemento = this.parentNode;
	var hermanoAnterior = getAnteriorElemento(esteElemento);
	if(hermanoAnterior != null){
		insertarAntes(esteElemento.parentNode, hermanoAnterior, esteElemento);
		cambiarIdRespuestas(esteElemento, -1);
		cambiarIdRespuestas(hermanoAnterior, 1);
	}

	checkBotonesRespuesta(esteElemento.parentNode);
}
//Funcion para cambiar el value del input del evento por el value del input inferior
function moverRespuestaAbajo(){
	var esteElemento = this.parentNode;
	var hermanoSiguiente = getSiguienteElemento(esteElemento);
	if(hermanoSiguiente != null){
		insertarDespues(esteElemento.parentNode, hermanoSiguiente, esteElemento);
		cambiarIdRespuestas(esteElemento, 1);
		cambiarIdRespuestas(hermanoSiguiente, -1);
	}

	checkBotonesRespuesta(esteElemento.parentNode);
}
//Funcion para eliminar la respuesta
function eliminarRespuesta(){
	var esteElemento = this.parentNode;
	var padre = esteElemento.parentNode;
	var siguienteElemento = getSiguienteElemento(esteElemento);

	var height = esteElemento.style.height == "" ? esteElemento.offsetHeight : parseInt(esteElemento.style.height);
	var totalHeight = 0;
	var idInterval = setInterval(frame, 1);
	esteElemento.style.overflow = "hidden";
	bloquearTodosBotonesRespuesta(padre);
	function frame() {
		if (height <= totalHeight) {
			clearInterval(idInterval);
			eliminarHijo(padre, esteElemento);
			while(siguienteElemento != null){
				cambiarIdRespuestas(siguienteElemento, -1);
				siguienteElemento = getSiguienteElemento(siguienteElemento);
			}
			desbloquearEliminarRespuesta(padre);
			checkBtnCrearFormulario();
			checkBtnAgregarRespuestas();
			checkBotonesRespuesta(padre);
		} else {
			height--;
			esteElemento.style.height = height + 'px';
		}
	}
}
//cambiar la id de las respuestas
function cambiarIdRespuestas(elemento, dif){
	var elementoSpan = elemento.getElementsByTagName("span")[0];
	var elementoInput = elemento.getElementsByTagName("div")[0].getElementsByTagName("input")[0];
	var splitSpan = elementoSpan.textContent.split(" ");
	var num = parseInt(splitSpan[splitSpan.length - 1]) + dif;

	var textoSpan = "";
	for(var i = 0; i < splitSpan.length - 1; i ++){
		textoSpan += splitSpan[i] + " ";
	}
	textoSpan+=num;
	elementoSpan.textContent = textoSpan;
	elementoInput.setAttribute("name", "res"+num);
}
//Devuelve el alto total dentro del padre que se la ha pasado
function getHeightContenedor(padre){
	var totalHeight = 0;
	for(var i = 0; i < padre.children.length; i++){
		totalHeight += padre.children[i].offsetHeight;
	}
	return totalHeight;
}
function checkBotonesRespuesta(padre){
	var cantHijos = padre.children.length;
	for(var i = 0; i < cantHijos; i++){
		var botones = padre.children[i].getElementsByTagName("button");
		//Boton subir
		if(botones[0].hasAttribute("disabled") && i > 0) botones[0].removeAttribute("disabled");
		else if(!botones[0].hasAttribute("disabled") && i == 0) botones[0].setAttribute("disabled", "true");

		//Boton bajar
		if(botones[1].hasAttribute("disabled") && i < cantHijos-1) botones[1].removeAttribute("disabled");
		else if(!botones[1].hasAttribute("disabled") && i == cantHijos-1) botones[1].setAttribute("disabled", "true");
	}
}
function bloquearTodosBotonesRespuesta(padre){
	var cantHijos = padre.children.length;
	for(var i = 0; i < cantHijos; i++){
		var botones = padre.children[i].getElementsByTagName("button");

		if(!botones[0].hasAttribute("disabled")) botones[0].setAttribute("disabled", "true");
		if(!botones[1].hasAttribute("disabled")) botones[1].setAttribute("disabled", "true");
		if(!botones[2].hasAttribute("disabled")) botones[2].setAttribute("disabled", "true");
	}
}
function desbloquearEliminarRespuesta(padre){
	var cantHijos = padre.children.length;
	for(var i = 0; i < cantHijos; i++){
		var botones = padre.children[i].getElementsByTagName("button");
		//Boton eliminar
		if(botones[2].hasAttribute("disabled")) botones[2].removeAttribute("disabled");
	}
}
//Generar una animacion para mostrar las respuestas
function animacionAdd(padre, hijo) {
	var heightHijo = hijo.offsetHeight;
	var height = padre.style.height == "" ? padre.offsetHeight - heightHijo : parseInt(padre.style.height);
	var totalHeight = getHeightContenedor(padre);
	clearInterval(interval_id_validacionEncuesta);
	interval_id_validacionEncuesta = setInterval(frame, 1);
	padre.style.overflow = "hidden";
	padre.style.height = height + 'px';
	function frame() {
		if (height >= totalHeight) {
			clearInterval(interval_id_validacionEncuesta);
			padre.removeAttribute("style");
		} else {
			height++;
			padre.style.height = height + 'px';
		}
	}
}
//Generar una animacion para ocultar y borrar las respuestas
function animacionDelAll(padre) {
	var height = padre.style.height == "" ? padre.offsetHeight : parseInt(padre.style.height);
	var totalHeight = 0;
	clearInterval(interval_id_validacionEncuesta);
	interval_id_validacionEncuesta = setInterval(frame, 1);
	padre.style.overflow = "hidden";
	function frame() {
		if (height <= totalHeight) {
			clearInterval(interval_id_validacionEncuesta);
			padre.removeAttribute("style");
			eliminarTodosLosHijos(padre);
			checkBtnAgregarRespuestas();
			checkBtnCrearFormulario();
		} else {
			height--;
			padre.style.height = height + 'px';
		}
	}
}
//Elimina todos los hijos del padre que se la ha pasado
function eliminarTodosLosHijos(padre){
	var hijos = padre.children;
	for(var i = hijos.length - 1; i >= 0; i--){
		eliminarHijo(padre, hijos[i]);
	}
}
//Fin manejar respuestas
//Manejar datas
//Devuelve el input que contiene el dia que sea hijo del padre pasado
function getInputDia(padre){
	return padre.children[2].children[0];
}
//Devuelve el input que contiene el mes que sea hijo del padre pasado
function getInputMes(padre){
	return padre.children[3].children[0];
}
//Devuelve el input que contiene el año que sea hijo del padre pasado
function getInputAny(padre){
	return padre.children[4].children[0];
}
//Devuelve cuantos dias tiene el mes de x año
function daysInMonth(month,year) {
    return new Date(year, month, 0).getDate();
}
//Añade dias a una fecha
function addDias(fecha, cant){
	if(fecha.getDate() + cant > daysInMonth(fecha.getDate(), fecha.getMonth(), fecha.getFullYear())){
		fecha.setDate(1);
		if(fecha.getMonth() == 11){ //0-11
			fecha.setFullYear(fecha.getFullYear() + 1);
			fecha.setMonth(1);
		}else{
			fecha.setMonth(fecha.getMonth() + 1);
		}
	}else{
		fecha.setDate(fecha.getDate() + cant);
	}
	return fecha;
}
//Devuelve una fecha con los milisegundos, segundos, minutos y horas a 0
function getFechaReseteada(dia = -1, mes = -1, any = -1){
	var data;
	if(any == -1){
		data = new Date();
	}else{
		data = new Date(dia, mes - 1, any);
	}
	data.setMilliseconds(0);
	data.setSeconds(0);
	data.setMinutes(0);
	data.setHours(0);
	return data;
}
//Devuelve la fecha de inicio reseteada del formulario o 
//devuelve false si la fecha esta incompleta
function getFechaInicio(){
	var padre = document.getElementById("dataInicio");
	var inputDia = getInputDia(padre);
	var inputMes = getInputMes(padre);
	var inputAny = getInputAny(padre);
	var dia = inputDia.value;
	var mes = inputMes.value;
	var any = inputAny.value;
	var isFechaCompleta = (dia != "" && mes != "" && any != "");

	if(!isFechaCompleta) return false;
	else return getFechaReseteada(any, mes, dia);
}
//True si la fecha de inicio esta incompleta, true si esta completa
function isDataInicioVacia(){
	var datasInicio = document.getElementById("dataInicio");
	return isVacio(getInputDia(datasInicio)) || isVacio(getInputMes(datasInicio)) || isVacio(getInputAny(datasInicio));
}
//True si la fecha de fin esta incompleta, true si esta completa
function isDataFinVacia(){
	var datasFin = document.getElementById("dataFin");
	return isVacio(getInputDia(datasFin)) || isVacio(getInputMes(datasFin)) || isVacio(getInputAny(datasFin));
}
//Comprueba si la fecha de inicio es correcta o no
function isValidoFechaInicio(){
	if(isDataInicioVacia()) return false;

	var padre = document.getElementById("dataInicio");
	var inputDia = getInputDia(padre);
	var inputMes = getInputMes(padre);
	var inputAny = getInputAny(padre);
	var dia = inputDia.value;
	var mes = inputMes.value;
	var any = inputAny.value;

	var fechaActual = getFechaReseteada();
	var fechaInicio = getFechaReseteada(any, mes, dia);
	
	return (isValidaFecha(dia, mes, any) && fechaInicio >= fechaActual);
}
//Comprueba si la fecha de fin es correcta o no
function isValidoFechaFin(){
	if(isDataFinVacia()) return false;

	var padre = document.getElementById("dataFin");
	var inputDia = getInputDia(padre);
	var inputMes = getInputMes(padre);
	var inputAny = getInputAny(padre);
	var dia = inputDia.value;
	var mes = inputMes.value;
	var any = inputAny.value;

	var fechaInicio = getFechaInicio();
	var fechaFin = getFechaReseteada(any, mes, dia);

	if(fechaInicio != false) fechaInicio = addDias(fechaInicio, 1);

	return (isValidaFecha(dia, mes, any) && fechaFin >= fechaInicio);
}
//Comprueba que los dias y mes de una fecha esten bien y que existan
function isValidaFecha(dia, mes, any){
	return (dia > 0 && dia <= daysInMonth(mes, any) && mes > 0 && mes < 13);
}
//Fin manejar datas
//Errores
//Crea un error para mostrarlo
function crearError(input, mensaje = "") {
	var errorActivo = isErrorActivo(input);
	if(!errorActivo){
		mostrarMensajeError(input);

		input.style.boxShadow = "0 0 5px red";
		//input.style.border = "1px solid red";
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
		getSiguienteElemento(input).textContent = mensaje;
		mostrarMensajeError(input);
		error = input;
	}
}
//Elimina un error
function eliminarError(input){
	if(isErrorActivo(input)){
		input.style.boxShadow = "";
		input.style.border = "";
		input.style.outline = "";
		eliminarHijo(input.parentNode, getSiguienteElemento(input));
	}
}
//oculta un error
function desactivarMensajeError(input){
	error = null;
	var siguienteElemento = getSiguienteElemento(input);
	if(siguienteElemento != null){
		siguienteElemento.style.display = "none";
	}
}
//Muesta un error ocultado
function mostrarMensajeError(input){
	var siguienteElemento = getSiguienteElemento(input);
	if(siguienteElemento != null){
		siguienteElemento.style.display = "";
	}
}
//Compruba si hay algun error (visible o oculto)
function isErrorActivo(input){
	var siguienteElemento = getSiguienteElemento(input);
	return siguienteElemento != null && siguienteElemento.getAttribute("class") == "tooltiptext";
}
//Fin de errores
//JS DOM
//Añadir un elemento al final
function agregarHijo(padre, hijo){
	padre.appendChild(hijo);
}
//Añadir un alemento antes de otro
function insertarAntes(padre, hijo, elemento){
	padre.insertBefore(elemento, hijo);
}
//Mover un elemento a otro lugar
function moverHijo(padre, hijo, destino){
	var clon = hijo.cloneNode(true);
	agregarHijo(destino, clon);
	eliminarHijo(padre, hijo);
}
//Eliminar un elemento
function eliminarHijo(padre, hijo){
	padre.removeChild(hijo);
}
//Insertar un elemento despues de otro
function insertarDespues(padre, hijo, elemento){
	if(getSiguienteElemento(hijo)){ 
		insertarAntes(padre, getSiguienteElemento(hijo), elemento);
	}else{
		agregarHijo(padre, elemento);
	}
}
//Obtener el siguiente elemento
function getSiguienteElemento(hijo){
	return hijo.nextSibling;
}
//Obtener el elemento anterior
function getAnteriorElemento(hijo){
	return hijo.previousSibling;
}
//Fin JS DOM
//Funciones inputs
//Desactiva el input pasado
function desactivarInput(input){
	if(!isActivoInput(input))
		input.disabled = true;
}
//Activa el input pasado
function activarInput(input){
	if(isActivoInput(input))
		input.disabled = false;
}
//Comprueba si esta activo un input
function isActivoInput(input) {
	return input.disabled == true;
}
//Comprueba si un input esta vacio
function isVacio(input){
	return input.value == "";
}
//Fin funciones inputs
//General
//Obtene la posicion del elemento pasado
function getPosition(elemento){
	var hermanos = elemento.parentNode.children;
	for(var i = 0; i < hermanos.length; i++){
		if(hermanos[i] === elemento){
			return i;
		}
	}
	return false;
}
//Fin General