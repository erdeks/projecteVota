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
		fechasInicio[i].getElementsByTagName("input")[0].addEventListener("input", checkFechaInicio);
		fechasInicio[i].getElementsByTagName("input")[0].addEventListener("blur", checkFechaInicio);
		//fechasInicio[i].getElementsByTagName("input")[0].value = "";
	}
	var fechasFin = document.getElementById("dataFin").children;
	for(var i = 0; i < fechasFin.length; i++){
		fechasFin[i].getElementsByTagName("input")[0].addEventListener("input", checkFechaFin);
		fechasFin[i].getElementsByTagName("input")[0].addEventListener("blur", checkFechaFin);
		//fechasFin[i].getElementsByTagName("input")[0].value = "";
	}

	addRespuesta();
	addRespuesta();
}
//Chequear
function checkBtnCrearFormulario(){
	var btnCrearFormulario = document.getElementById('crearForumario');
	var inputPregunta = document.getElementById('pregunta');

	if(isVacio(inputPregunta) || getCantRespuestas() < 2 || isRespuestaVacia() || !isValidoFechaInicio() || !isValidoFechaFin()){
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
function desactivarErroresFechaInicio(inputActual = null){
	var padre = document.getElementById("dataInicio");
	var inputDia = padre.children[0].children[0];
	var inputMes = padre.children[1].children[0];
	var inputAny = padre.children[2].children[0];
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
function activarErroresFechaInicio(inputActual = null){
	var padre = document.getElementById("dataInicio");
	var inputDia = padre.children[0].children[0];
	var inputMes = padre.children[1].children[0];
	var inputAny = padre.children[2].children[0];
	var dia = inputDia.value;
	var mes = inputMes.value;
	var any = inputAny.value;
	var error = false;
	if(inputActual != null){
		switch(getPosition(inputActual.parentNode)){
			case 0: //Dia
				if(dia == ""){
					crearError(inputDia, "EL dia no puede estar vacio.");
				}else if(dia <= 0){
					crearError(inputDia, "El dia no puede ser menor de 1.");
					error = true;
				}
				break;
			case 1: //Mes
				if(mes == ""){
					crearError(inputMes, "EL mes no puede estar vacio.");
				}else if(mes <= 0 || mes > 12){
					crearError(inputMes, "No existe el mes.");
					error = true;
				}
				break;
			case 2: //Año
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

function desactivarErroresFechaFin(inputActual = null){
	var padre = document.getElementById("dataFin");
	var inputDia = padre.children[0].children[0];
	var inputMes = padre.children[1].children[0];
	var inputAny = padre.children[2].children[0];
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
			eliminarError(inputMes);		eliminarError(inputAny);
	}else if(inputActual != null && !isVacio(inputActual)){
		eliminarError(inputActual);
	}
}
function activarErroresFechaFin(inputActual = null){
	var padre = document.getElementById("dataFin");
	var inputDia = padre.children[0].children[0];
	var inputMes = padre.children[1].children[0];
	var inputAny = padre.children[2].children[0];
	var dia = inputDia.value;
	var mes = inputMes.value;
	var any = inputAny.value;
	var error = false;

	if(inputActual != null){
		switch(getPosition(inputActual.parentNode)){
			case 0: //Dia
				if(dia == ""){
					alert("a")
					crearError(inputDia, "EL dia no puede estar vacio.");
				}else if(dia <= 0){
					crearError(inputDia, "El dia no puede ser menor de 1.");
					error = true;
				}
				break;
			case 1: //Mes
				if(mes == ""){
					crearError(inputMes, "EL mes no puede estar vacio.");
				}else if(mes <= 0 || mes > 12){
					crearError(inputMes, "No existe el mes.");
					error = true;
				}
				break;
			case 2: //Año
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
			crearError(inputMes, "La fecha de fin tiene que tener 1 dia de diferencia.");
		}
	}
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
	elementoInput.setAttribute("name", "res" + (getCantRespuestas() + 1));
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
function getFechaInicio(){
	var padre = document.getElementById("dataInicio");
	var inputDia = padre.children[0].children[0];
	var inputMes = padre.children[1].children[0];
	var inputAny = padre.children[2].children[0];
	var dia = inputDia.value;
	var mes = inputMes.value;
	var any = inputAny.value;
	var isFechaCompleta = (dia != "" && mes != "" && any != "");

	if(!isFechaCompleta) return false;
	else return getFechaReseteada(any, mes, dia);
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
function isValidoFechaInicio(){
	if(isDataInicioVacia()) return false;

	var padre = document.getElementById("dataInicio");
	var inputDia = padre.children[0].children[0];
	var inputMes = padre.children[1].children[0];
	var inputAny = padre.children[2].children[0];
	var dia = inputDia.value;
	var mes = inputMes.value;
	var any = inputAny.value;

	var fechaActual = getFechaReseteada();
	var fechaInicio = getFechaReseteada(any, mes, dia);
	
	return (isValidaFecha(dia, mes, any) && fechaInicio >= fechaActual);
}
function isValidoFechaFin(){
	if(isDataFinVacia()) return false;

	var padre = document.getElementById("dataFin");
	var inputDia = padre.children[0].children[0];
	var inputMes = padre.children[1].children[0];
	var inputAny = padre.children[2].children[0];
	var dia = inputDia.value;
	var mes = inputMes.value;
	var any = inputAny.value;

	var fechaInicio = getFechaInicio();
	var fechaFin = getFechaReseteada(any, mes, dia);

	if(fechaInicio != false) fechaInicio = addDias(fechaInicio, 1);

	return (isValidaFecha(dia, mes, any) && fechaFin >= fechaInicio);
}
function isValidaFecha(dia, mes, any){
	return (dia > 0 && dia <= daysInMonth(mes, any) && mes > 0 && mes < 13);
}
//Fin manejar datas
//Errores
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