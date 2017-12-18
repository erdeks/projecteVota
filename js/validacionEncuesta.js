//@Nombre: ValidacionEncuesta.js
//@Fecha de creación: 1-12-2017
//@Creador: Marc Colominas Rojas
//@Descipción: Genera, valida que los campos esten correctamente y genera la animación de las respuestas del formulario de crear encuesta

//Contiene el elemento DOM del error que se muestra en el formulario
var error = null;
//Contiene el id interval de la animacion de las encuestas
var interval_id_validacionEncuesta = -1;
//Las horas que tiene que tener como minimo de diferencia entre la fecha de inicio y la fecha de fin
var minHorasEntrefechas = 4
//Desface de minutos desde la zona horaria centras
var desfaceHorario = 0;
//Llamar a la funcion onLoad cuando se carge la pagina
window.addEventListener('load', onLoad, true);

//@Descripción: Funcion que se llama al cargar la pagina.
//@Params: Ninguno
//@Return: Ninguno
function onLoad(){
    document.getElementById("generarForm").addEventListener("click", generarForumario);
}

//Inicio crear Formulario

//@Descripción: Generar Formulario, añadirlo a la pagina y agregar todos sus eventos
//@Params: Ninguno
//@Return: Ninguno
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

	var elementoForm = document.createElement("form");
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

	elementoForm.addEventListener("submit", recalcularTiempo);

	checkBtnAgregarRespuestas();
	checkBtnCrearFormulario();
}

//@Descripción: Generar el elemento dom de la fecha inicio con sus eventos
//@Params: Ninguno
//@Return: DOM Element
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

	var elementoDivErrorHora = document.createElement("div");
		elementoDivErrorHora.setAttribute("class", "tooltip");

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

	var elementoInputHora = document.createElement("input");
		elementoInputHora.setAttribute("type", "number");
		elementoInputHora.setAttribute("name", "horaInicio");
		elementoInputHora.setAttribute("placeholder", "HH");
		elementoInputHora.required = true;

	agregarHijo(elementoDiv, elementoLavel);
	agregarHijo(elementoLavel, contenidoLavel);
	agregarHijo(elementoDiv, elementoBr);
	agregarHijo(elementoDiv, elementoDivErrorDia);
	agregarHijo(elementoDiv, elementoDivErrorMes);
	agregarHijo(elementoDiv, elementoDivErrorAny);
	agregarHijo(elementoDiv, elementoDivErrorHora);
	agregarHijo(elementoDivErrorDia, elementoInputDia);
	agregarHijo(elementoDivErrorMes, elementoInputMes);
	agregarHijo(elementoDivErrorAny, elementoInputAny);
	agregarHijo(elementoDivErrorHora, elementoInputHora);

	//Eventos
	elementoInputDia.addEventListener("input", checkFechaInicio);
	elementoInputDia.addEventListener("blur", checkFechaInicio);
	elementoInputMes.addEventListener("input", checkFechaInicio);
	elementoInputMes.addEventListener("blur", checkFechaInicio);
	elementoInputAny.addEventListener("input", checkFechaInicio);
	elementoInputAny.addEventListener("blur", checkFechaInicio);
	elementoInputHora.addEventListener("input", checkFechaInicio);
	elementoInputHora.addEventListener("blur", checkFechaInicio);

	return elementoDiv;
}

//@Descripción: Generar el elemento dom de la fecha fin con sus eventos
//@Params: Ninguno
//@Return: DOM Element
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

	var elementoDivErrorHora = document.createElement("div");
		elementoDivErrorHora.setAttribute("class", "tooltip");

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
		elementoInputAny.required = true;

	var elementoInputHora = document.createElement("input");
		elementoInputHora.setAttribute("type", "number");
		elementoInputHora.setAttribute("name", "horaFin");
		elementoInputHora.setAttribute("placeholder", "HH");
		elementoInputHora.required = true;

	agregarHijo(elementoDiv, elementoLavel);
	agregarHijo(elementoLavel, contenidoLavel);
	agregarHijo(elementoDiv, elementoBr);
	agregarHijo(elementoDiv, elementoDivErrorDia);
	agregarHijo(elementoDiv, elementoDivErrorMes);
	agregarHijo(elementoDiv, elementoDivErrorAny);
	agregarHijo(elementoDiv, elementoDivErrorHora);
	agregarHijo(elementoDivErrorDia, elementoInputDia);
	agregarHijo(elementoDivErrorMes, elementoInputMes);
	agregarHijo(elementoDivErrorAny, elementoInputAny);
	agregarHijo(elementoDivErrorHora, elementoInputHora);

	//Eventos
	elementoInputDia.addEventListener("input", checkFechaFin);
	elementoInputDia.addEventListener("blur", checkFechaFin);
	elementoInputMes.addEventListener("input", checkFechaFin);
	elementoInputMes.addEventListener("blur", checkFechaFin);
	elementoInputAny.addEventListener("input", checkFechaFin);
	elementoInputAny.addEventListener("blur", checkFechaFin);
	elementoInputHora.addEventListener("input", checkFechaFin);
	elementoInputHora.addEventListener("blur", checkFechaFin);

	return elementoDiv;
}

//@Descripción: Generar el elemento dom de la pregunta con sus eventos
//@Params: Ninguno
//@Return: DOM Element
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

//@Descripción: Generar el elemento dom de la descripcion
//@Params: Ninguno
//@Return: DOM Element
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

//@Descripción: Generar el elemento dom multirespuesta
//@Params: Ninguno
//@Return: DOM Element
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
//@Descripción: Generar el elemento dom de los botones (añadir respuesta, eliminar todas respuestas, enviar) con sus eventos
//@Params: Ninguno
//@Return: DOM Element
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

//@Descripción: Generar el elemento dom de las respuestas (Donde se generarán las respuestas)
//@Params: Ninguno
//@Return: DOM Element
function getElementoRespuestas(){
	var elementoDiv = document.createElement("div");
		elementoDiv.setAttribute("id", "respuestas");

	return elementoDiv;
}

//@Descripción: Recalcular el desface horario
//@Params: Ninguno
//@Return: Ninguno
function recalcularTiempo(){
	var desface = new Date().getTimezoneOffset() + desfaceHorario;
	recalcularTiempoInputs(document.getElementById("dataInicio"), desface);
	recalcularTiempoInputs(document.getElementById("dataFin"), desface);
}

//@Descripción: Recalcular el desface horario de los inputs de inicio
//@Params: padre (objeto dom), desface (Integer)
//@Return: Ninguno
function recalcularTiempoInputs(padre, desface){
	var inputHora = getInputHora(padre);
	var inputDia = getInputDia(padre);
	var inputMes = getInputMes(padre);
	var inputAny = getInputAny(padre);
	var hora = parseInt(inputHora.value);
	var dia = parseInt(inputDia.value);
	var mes = parseInt(inputMes.value);
	var any = parseInt(inputAny.value);

	hora += (desface / 60);
	if(hora > 23){
		hora -= 24;
		dia ++;
		if(dia > daysInMonth(any, mes)){
			dia -= daysInMonth(any, mes);
			mes ++;
			if(mes > 12){
				mes = 1;
				any ++;
			}
		}
	}else if(hora < 0){
		hora += 24;
		dia --;
		if(dia < 1){
			mes --;
			dia = daysInMonth(any, mes) - dia;
			if(mes < 1){
				mes -= 12;
				any --;
			}
		}
	}

	inputHora.value = hora;
	inputDia.value = dia;
	inputMes.value = mes;
	inputAny.value = any;
}

//Fin crear Formulario

//Chequear

//@Descripción: Revisa que los parametros necesarios se cumplan para activar o desactivar el botón para enviar el formulario
//@Params: Ninguno
//@Return: Ninguno
function checkBtnCrearFormulario(){
	var btnCrearFormulario = document.getElementById('crearForumario');
	var inputPregunta = document.getElementById('pregunta');

	if(isVacio(inputPregunta) || getCantRespuestas() < 2 || isRespuestaVacia() || !isValidoFechaInicio() || !isValidoFechaFin()){
		desactivarInput(btnCrearFormulario);
	}else{
		activarInput(btnCrearFormulario);
	}
}

//@Descripción: Revisa que los parametros necesarios se cumplan para activar o desactivar el botón para añadir mas respuestas
//@Params: Ninguno
//@Return: Ninguno
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

//@Descripción: Cuando el texto se modifica en el input pregunta, gestiona los errores y valida el estado del botón de crear formularios
//@Params: Ninguno
//@Return: Ninguno
function checkInputPreguntaTextoCambia(){
	if(error != null){
		desactivarMensajeError(error);
	}
	if(!isVacio(this)){
		eliminarError(this);
	}
	checkBtnCrearFormulario();
}

//@Descripción: Cuando se pierde el foco en el input pregunta, genera el error en caso que este vacio
//@Params: Ninguno
//@Return: Ninguno
function checkInputPreguntaFocoPerdido(){
	if(isVacio(this)){
		crearError(this, "La pregunta no puede estar vacia.");
	}
}

//@Descripción: Cuando el texto se modifica en el input respuesta, gestiona los errores y valida el estado de'los botónes de crear formularios y agregar respuesta
//@Params: Ninguno
//@Return: Ninguno
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

//@Descripción: Cuando se pierde el foco en el input respuesta, genera el error en caso que este vacio
//@Params: Ninguno
//@Return: Ninguno
function checkInputsRespuestasFocoPerdido(){
	if(isVacio(this)){
		crearError(this, "La respuesta no puede estar vacia.");
	}
}

//@Descripción: Desactiva los errores activos, valida el dia, mes, año y hora de la fecha de inicio que esten correctos, genera sus errores, se accede cuando el texto cambia o se pierde el foco en sus inputs 
//@Params: Ninguno
//@Return: Ninguno
function checkFechaInicio(){
	if(error != null){
		desactivarMensajeError(error);
	}

	//Chechear antes los errores de las fechas de fin, por si se cambio algun valor al formulario de inicio que de error en la fecha de fin, por ejemplo el intervalo minimo entre fechas
	desactivarErroresFechaFin();
	activarErroresFechaFin();

	desactivarErroresFechaInicio();
	activarErroresFechaInicio(this);

	checkBtnCrearFormulario();
}

//@Descripción: Desactiva los errores activos, valida el dia, mes, año y hora de la fecha de fin que esten correctos, genera sus errores, se accede cuando el texto cambia o se pierde el foco en sus inputs 
//@Params: Ninguno
//@Return: Ninguno
function checkFechaFin(){
	if(error != null){
		desactivarMensajeError(error);
	}

	desactivarErroresFechaFin();
	activarErroresFechaFin(this);
	
	checkBtnCrearFormulario();
}

//@Descripción: Comprueba si desactiva los errores de la fecha de inicio
//@Params: Ninguno
//@Return: Ninguno
function desactivarErroresFechaInicio(){
	var padre = document.getElementById("dataInicio");
	var inputDia = getInputDia(padre);
	var inputMes = getInputMes(padre);
	var inputAny = getInputAny(padre);
	var inputHora = getInputHora(padre);
	var dia = inputDia.value;
	var mes = inputMes.value;
	var any = inputAny.value;
	var hora = inputHora.value;
	var isFechaCompleta = (dia != "" && mes != "" && any != "" && hora != "");

	if(isFechaCompleta){
		var fechaActual = getFechaReseteada();
		var fechaInicio = getFechaReseteada(any, mes, dia, hora);

		if(fechaInicio >= fechaActual){
			if(dia > 0 && dia <= daysInMonth(any, mes))
				eliminarError(inputDia);
			if(mes > 0 && mes < 13)
				eliminarError(inputMes);
			if(hora >= 0 && hora < 24)
				eliminarError(inputHora);
			eliminarError(inputAny);
		}
	}else{
		if(dia != "" && dia > 0 && dia <= daysInMonth(any, mes))
			eliminarError(inputDia);
		if(mes != "" && mes > 0 && mes < 13)
			eliminarError(inputMes);
		if(hora != "" && hora >= 0 && hora < 24)
			eliminarError(inputHora);
		if(any != "")
			eliminarError(inputAny);
	}
}
//@Descripción: Comprueba si activa los errores de la fecha de inicio, se le puede pasar un input DOM opcional, si se le pasa, detecta que input es (hora, mes ...) y hace la validacion para ese input
//@Params: [inputActual] (Dom Element)
//@Return: Ninguno
function activarErroresFechaInicio(inputActual = null){
	var padre = document.getElementById("dataInicio");
	var inputDia = getInputDia(padre);
	var inputMes = getInputMes(padre);
	var inputAny = getInputAny(padre);
	var inputHora = getInputHora(padre);
	var dia = inputDia.value;
	var mes = inputMes.value;
	var any = inputAny.value;
	var hora = inputHora.value;
	var error = false;
	if(inputActual != null){
		switch(getPosition(inputActual.parentNode)){
			case getPosition(getInputHora(padre).parentNode): //Hora
				if(hora == ""){
					crearError(inputHora, "La hora no puede estar vacio.");
				}else if(hora < 0 || hora > 23){
					crearError(inputHora, "El rango de horas estra entre el 0 y el 23.");
					error = true;
				}
				break;
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
		var isFechaCompleta = (dia != "" && mes != "" && any != "" && hora != "");
		if(isFechaCompleta){
			var fechaActual = getFechaReseteada();
			var fechaInicio = fechaInicio = getFechaReseteada(any, mes, dia, hora);

			if(dia > daysInMonth(mes, any)){
				crearError(inputDia, "El mes seleccionado solo tiene "+daysInMonth(mes, any)+" dias.");
			}else if(fechaInicio < fechaActual){
				crearError(inputDia, "");
				crearError(inputAny, "");
				crearError(inputHora, "");
				crearError(inputMes, "La fecha de inicio no puede ser menor a la fecha actual");
			}
		}
	}
}

//@Descripción: Comprueba si desactiva los errores de la fecha de Fin
//@Params: Ninguno
//@Return: Ninguno
function desactivarErroresFechaFin(){
	var padre = document.getElementById("dataFin");
	var inputDia = getInputDia(padre);
	var inputMes = getInputMes(padre);
	var inputAny = getInputAny(padre);
	var inputHora = getInputHora(padre);
	var dia = inputDia.value;
	var mes = inputMes.value;
	var any = inputAny.value;
	var hora = inputHora.value;

	var isFechaCompleta = (dia != "" && mes != "" && any != "" && hora != "");
	
	if(isFechaCompleta){
		var fechaInicio = getFechaInicio();
		if(fechaInicio != false){
			fechaInicio = addHoras(fechaInicio, minHorasEntrefechas);
			var fechaFin = getFechaReseteada(any, mes, dia, hora);

			if(fechaFin >= fechaInicio){
				if(dia > 0 && dia <= daysInMonth(any, mes))
					eliminarError(inputDia);
				if(mes > 0 && mes < 13)
					eliminarError(inputMes);
				if(hora >= 0 && hora < 24)
					eliminarError(inputHora);
				eliminarError(inputAny);
			}
		}
	}else{
		if(dia != "" && mes != "" && any != "" && dia > 0 && dia <= daysInMonth(any, mes))
			eliminarError(inputDia);
		if(mes != "" && mes > 0 && mes < 13)
			eliminarError(inputMes);
		if(hora != "" && hora >= 0 && hora < 24)
			eliminarError(inputHora);
		if(any != "")
			eliminarError(inputAny);
	}
}

//@Descripción: Comprueba si activa los errores de la fecha de fin, se le puede pasar un input DOM opcional, si se le pasa, detecta que input es (hora, mes ...) y hace la validacion para ese input
//@Params: [inputActual] (Dom Element)
//@Return: Ninguno
function activarErroresFechaFin(inputActual = null){
	var padre = document.getElementById("dataFin");
	var inputDia = getInputDia(padre);
	var inputMes = getInputMes(padre);
	var inputAny = getInputAny(padre);
	var inputHora = getInputHora(padre);
	var dia = inputDia.value;
	var mes = inputMes.value;
	var any = inputAny.value;
	var hora = inputHora.value;
	var error = false;

	if(inputActual != null){
		switch(getPosition(inputActual.parentNode)){
			case getPosition(getInputHora(padre).parentNode): //Hora
				if(hora == ""){
					crearError(inputHora, "La hora no puede estar vacio.");
				}else if(hora < 0 || hora > 23){
					crearError(inputHora, "El rango de horas estra entre el 0 y el 23.");
					error = true;
				}
				break;
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
		var isFechaCompleta = (dia != "" && mes != "" && any != "" && hora != "");

		if(isFechaCompleta){
			var fechaInicio = getFechaInicio();
			var fechaFin = getFechaReseteada(any, mes, dia, hora);

			if(fechaInicio != false)
				fechaInicio = addHoras(fechaInicio, minHorasEntrefechas);

			if(dia > daysInMonth(mes, any)){
				crearError(inputDia, "El mes seleccionado solo tiene "+daysInMonth(mes, any)+" dias.");
			}else if(fechaInicio != false && fechaFin < fechaInicio){
				crearError(inputDia, "");
				crearError(inputAny, "");
				crearError(inputHora, "");
				crearError(inputMes, "La fecha de cierre tiene que tener "+ minHorasEntrefechas +" " +(minHorasEntrefechas == 1 ? "hora" : " horas") + " de diferencia.");
			}
		}
	}
}

//Fin chequear
//Manejar respuestas

//@Descripción: Obtener cuantas respuestas se han creado
//@Params: Ninguno
//@Return: Ninguno
function getCantRespuestas(){
	return document.getElementById("respuestas").children.length;
}

//@Descripción: Debuelve true si hay alguna respuesta vacia, false si todas estan todas llenas
//@Params: Ninguno
//@Return: Ninguno
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

//@Descripción: Crea una nueva respuesta, con sus eventos
//@Params: Ninguno
//@Return: Ninguno
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
	animacionAdd(elementoDiv);

	checkBtnCrearFormulario();
	checkBtnAgregarRespuestas();
	checkBotonesRespuesta(padre);
}

//@Descripción: Obtener el boton hacia arriba
//@Params: Ninguno
//@Return: Dom Element
function getButtonUp(){
	var elementoButton = document.createElement("button");
		elementoButton.setAttribute("type", "button")
	var elementoI = document.createElement("i");
		elementoI.setAttribute("class", "fa fa-arrow-up");

	agregarHijo(elementoButton, elementoI);

	elementoButton.addEventListener("click", moverRespuestaArriba);

	return elementoButton;
}

//@Descripción: Obtener el boton hacia abajo
//@Params: Ninguno
//@Return: Dom Element
function getButtonDown(){
	var elementoButton = document.createElement("button");
		elementoButton.setAttribute("type", "button")
	var elementoI = document.createElement("i");
		elementoI.setAttribute("class", "fa fa-arrow-down");

	agregarHijo(elementoButton, elementoI);

	elementoButton.addEventListener("click", moverRespuestaAbajo);
	
	return elementoButton;
}

//@Descripción: Obtener el boton eliminar
//@Params: Ninguno
//@Return: Dom Element
function getButtonRemove(){
	var elementoButton = document.createElement("button");
		elementoButton.setAttribute("type", "button")
	var elementoI = document.createElement("i");
		elementoI.setAttribute("class", "fa fa-trash-o");

	agregarHijo(elementoButton, elementoI);

	elementoButton.addEventListener("click", eliminarRespuesta);
	
	return elementoButton;
}

//@Descripción: Elimina todas las respuestas y ejecuta su animacion
//@Params: Ninguno
//@Return: Ninguno
function eliminarTodasRespuestas(){
	var padre = document.getElementById('respuestas');

	animacionDelAll(padre);
}

//@Descripción: Mueve el input actual una posicion mas arriba y valida si los botones de subir y bajar tienen que estar activados o desactivados
//@Params: Ninguno
//@Return: Ninguno
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

//@Descripción: Mueve el input actual una posicion mas abajo y valida si los botones de subir y bajar tienen que estar activados o desactivados
//@Params: Ninguno
//@Return: Ninguno
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

//@Descripción: Elimina la respuesta donde se genera el evento, ejecutando una animacion y validando todo lo necesario
//@Params: Ninguno
//@Return: Ninguno
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

//@Descripción: Cambia el tag name y el contenido de label para que se ajuste al id indicado, el elemento es el objeto DOM padre que contiene todos los componentes de la respuesta y la dif cuanto incrementar o decrementar el id
//@Params: elemento (objeto dom), dif (Number)
//@Return: Ninguno
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

//@Descripción: Devuelve el alto total de los primeros hijos del padre indicado
//@Params: padre (objeto dom)
//@Return: Ninguno
function getHeightContenedor(padre){
	var totalHeight = 0;
	for(var i = 0; i < padre.children.length; i++){
		totalHeight += padre.children[i].offsetHeight;
	}
	return totalHeight;
}

//@Descripción: Activa o desactiva los botones de subir y bajar de las respuestas, se le pasa el padre que contiene todos los componentes de la respuesta.
//@Params: padre (objeto dom)
//@Return: Ninguno
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

//@Descripción: Desactiva los botones de subir, bajar, borrar de las respuestas, se le pasa el padre que contiene todos los componentes de la respuesta.
//@Params: padre (objeto dom)
//@Return: Ninguno
function bloquearTodosBotonesRespuesta(padre){
	var cantHijos = padre.children.length;
	for(var i = 0; i < cantHijos; i++){
		var botones = padre.children[i].getElementsByTagName("button");

		if(!botones[0].hasAttribute("disabled")) botones[0].setAttribute("disabled", "true");
		if(!botones[1].hasAttribute("disabled")) botones[1].setAttribute("disabled", "true");
		if(!botones[2].hasAttribute("disabled")) botones[2].setAttribute("disabled", "true");
	}
}

//@Descripción: Activa los botones de eliminar de las respuestas, se le pasa el padre que contiene todos los componentes de la respuesta.
//@Params: padre (objeto dom)
//@Return: Ninguno
function desbloquearEliminarRespuesta(padre){
	var cantHijos = padre.children.length;
	for(var i = 0; i < cantHijos; i++){
		var botones = padre.children[i].getElementsByTagName("button");
		//Boton eliminar
		if(botones[2].hasAttribute("disabled")) botones[2].removeAttribute("disabled");
	}
}

//@Descripción: Generar una animacion para mostrar las respuestas, se le pasa el hijo que se agrega.
//@Params: hijo (objeto dom)
//@Return: Ninguno
function animacionAdd(hijo) {
	var padre = hijo.parentNode;
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

//@Descripción: Elimina todos los componentes del objeto dom especificado, haciendo una animacion al eliminarlos
//@Params: padre (objeto dom)
//@Return: Ninguno
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

//@Descripción: Elimina todos los hijos del padre que se la ha pasado
//@Params: padre (objeto dom)
//@Return: Ninguno
function eliminarTodosLosHijos(padre){
	var hijos = padre.children;
	for(var i = hijos.length - 1; i >= 0; i--){
		eliminarHijo(padre, hijos[i]);
	}
}

//Fin manejar respuestas
//Manejar datas

//@Descripción: Devuelve el input que contiene el dia que sea hijo del padre pasado
//@Params: padre (objeto dom)
//@Return: objeto dom
function getInputDia(padre){
	return padre.children[2].children[0];
}

//@Descripción: Devuelve el input que contiene el mes que sea hijo del padre pasado
//@Params: padre (objeto dom)
//@Return: objeto dom
function getInputMes(padre){
	return padre.children[3].children[0];
}

//@Descripción: Devuelve el input que contiene el año que sea hijo del padre pasado
//@Params: padre (objeto dom)
//@Return: objeto dom
function getInputAny(padre){
	return padre.children[4].children[0];
}

//@Descripción: Devuelve el input que contiene la hora que sea hijo del padre pasado
//@Params: padre (objeto dom)
//@Return: objeto dom
function getInputHora(padre){
	return padre.children[5].children[0];
}

//@Descripción: Devuelve cuantos dias tiene el mes de x año
//@Params: month (Integer), year (Integer)
//@Return: objeto Date
function daysInMonth(month, year) {
    return new Date(year, month, 0).getDate();
}

//@Descripción: Añade horas a una fecha
//@Params: fecha (objeto date), cant (Integer)
//@Return: objeto Date
function addHoras(fecha, cant){
	fecha.setHours(fecha.getHours() + cant);
	return fecha;
}

//@Descripción: Devuelve una fecha con los milisegundos, segundos, minutos a 0, si se la pasa todos los parametros generara una fecha con los parametros pasados, sino creara una la fecha actual
//@Params: any (Integer), mes (Integer), dia (Integer), hora (Integer)
//@Return: objeto Date
function getFechaReseteada(any = -1, mes = -1, dia = -1, hora = -1){
	var data;
	if(hora == -1){
		data = new Date();
	}else{
		data = new Date(any, mes - 1, dia, hora);
	}
	data.setMilliseconds(0);
	data.setSeconds(0);
	data.setMinutes(0);
	return data;
}

//@Descripción: Devuelve la fecha de inicio reseteada del formulario o devuelve false si la fecha esta incompleta
//@Params: Ninguno
//@Return: objeto Date | false
function getFechaInicio(){
	var padre = document.getElementById("dataInicio");
	var inputDia = getInputDia(padre);
	var inputMes = getInputMes(padre);
	var inputAny = getInputAny(padre);
	var inputHora = getInputHora(padre);
	var dia = inputDia.value;
	var mes = inputMes.value;
	var any = inputAny.value;
	var hora = inputHora.value;
	var isFechaCompleta = (dia != "" && mes != "" && any != "" && hora != "");

	if(!isFechaCompleta) return false;
	else return getFechaReseteada(any, mes, dia, hora);
}

//@Descripción: Debuelve True si la fecha de inicio esta vacia, true si esta llena
//@Params: Ninguno
//@Return: Boolean
function isDataInicioVacia(){
	var datasInicio = document.getElementById("dataInicio");
	return isVacio(getInputDia(datasInicio)) || isVacio(getInputMes(datasInicio)) || isVacio(getInputAny(datasInicio)) || isVacio(getInputHora(datasInicio));
}

//@Descripción: Debuelve True si la fecha de fin esta vacia, true si esta llena
//@Params: Ninguno
//@Return: Boolean
function isDataFinVacia(){
	var datasFin = document.getElementById("dataFin");
	return isVacio(getInputDia(datasFin)) || isVacio(getInputMes(datasFin)) || isVacio(getInputAny(datasFin)) || isVacio(getInputHora(datasFin));
}

//@Descripción: Comprueba si la fecha de inicio es correcta o no
//@Params: Ninguno
//@Return: Boolean
function isValidoFechaInicio(){
	if(isDataInicioVacia()) return false;

	var padre = document.getElementById("dataInicio");
	var inputDia = getInputDia(padre);
	var inputMes = getInputMes(padre);
	var inputAny = getInputAny(padre);
	var inputHora = getInputHora(padre);
	var dia = inputDia.value;
	var mes = inputMes.value;
	var any = inputAny.value;
	var hora = inputHora.value;

	var fechaActual = getFechaReseteada();
	var fechaInicio = getFechaReseteada(any, mes, dia, hora);
	
	return (isValidaFecha(any, mes, dia, hora) && fechaInicio >= fechaActual);
}

//@Descripción: Comprueba si la fecha de fin es correcta o no
//@Params: Ninguno
//@Return: Boolean
function isValidoFechaFin(){
	if(isDataFinVacia()) return false;

	var padre = document.getElementById("dataFin");
	var inputDia = getInputDia(padre);
	var inputMes = getInputMes(padre);
	var inputAny = getInputAny(padre);
	var inputHora = getInputHora(padre);
	var dia = inputDia.value;
	var mes = inputMes.value;
	var any = inputAny.value;
	var hora = inputHora.value;

	var fechaInicio = getFechaInicio();
	var fechaFin = getFechaReseteada(any, mes, dia, hora);

	if(fechaInicio != false) fechaInicio = addHoras(fechaInicio, minHorasEntrefechas);

	return (isValidaFecha(any, mes, dia, hora) && fechaFin >= fechaInicio);
}

//@Descripción: Comprueba que los dias y mes de una fecha esten bien y que existan
//@Params: any (Integer), mes (Integer), dia (Integer), hora (Integer)
//@Return: Boolean
function isValidaFecha(any, mes, dia, hora){
	return (dia > 0 && dia <= daysInMonth(mes, any) && mes > 0 && mes < 13 && hora >= 0 && hora < 24);
}
//Fin manejar datas
//Errores

//@Descripción: Crea un error del input indicado y con el mensaje pasado y lo muestra
//@Params: input (objeto dom), mensaje [String]
//@Return: Ninguno
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

//@Descripción: Elimina un error del input indicado
//@Params: input (objeto dom)
//@Return: Ninguno
function eliminarError(input){
	if(isErrorActivo(input)){
		input.style.boxShadow = "";
		input.style.border = "";
		input.style.outline = "";
		eliminarHijo(input.parentNode, getSiguienteElemento(input));
	}
}

//@Descripción: Oculta un error del input indicado
//@Params: input (objeto dom)
//@Return: Ninguno
function desactivarMensajeError(input){
	error = null;
	var siguienteElemento = getSiguienteElemento(input);
	if(siguienteElemento != null){
		siguienteElemento.style.display = "none";
	}
}

//@Descripción: Muesta un error ocultado del input indicado
//@Params: input (objeto dom)
//@Return: Ninguno
function mostrarMensajeError(input){
	var siguienteElemento = getSiguienteElemento(input);
	if(siguienteElemento != null){
		siguienteElemento.style.display = "";
	}
}

//@Descripción: Compruba si hay algun error (visible o oculto) del input indicado
//@Params: padre (objeto dom)
//@Return: boolean
function isErrorActivo(input){
	var siguienteElemento = getSiguienteElemento(input);
	return siguienteElemento != null && siguienteElemento.getAttribute("class") == "tooltiptext";
}

//Fin de errores
//JS DOM

//@Descripción: Añadir un elemento al final
//@Params: padre (objeto dom), hijo (objeto dom)
//@Return: Ninguno
function agregarHijo(padre, hijo){
	padre.appendChild(hijo);
}

//@Descripción: Añadir un alemento antes de otro
//@Params: padre (objeto dom), hijo (objeto dom), elemento (objeto dom)
//@Return: Ninguno
function insertarAntes(padre, hijo, elemento){
	padre.insertBefore(elemento, hijo);
}

//@Descripción: Mover un elemento a otro lugar
//@Params: padre (objeto dom), hijo (objeto dom), destino (objeto dom)
//@Return: Ninguno
function moverHijo(padre, hijo, destino){
	var clon = hijo.cloneNode(true);
	agregarHijo(destino, clon);
	eliminarHijo(padre, hijo);
}

//@Descripción: Eliminar un elemento
//@Params: padre (objeto dom), hijo (objeto dom)
//@Return: Ninguno
function eliminarHijo(padre, hijo){
	padre.removeChild(hijo);
}

//@Descripción: Insertar un elemento despues de otro
//@Params: padre (objeto dom), hijo (objeto dom), elemento (objeto dom)
//@Return: Ninguno
function insertarDespues(padre, hijo, elemento){
	if(getSiguienteElemento(hijo)){ 
		insertarAntes(padre, getSiguienteElemento(hijo), elemento);
	}else{
		agregarHijo(padre, elemento);
	}
}

//@Descripción: Obtener el siguiente elemento
//@Params: hijo (objeto dom)
//@Return: objeto dom | null
function getSiguienteElemento(hijo){
	return hijo.nextSibling;
}

//@Descripción: Obtener el elemento anterior
//@Params: padre (objeto dom)
//@Return: objeto dom | null
function getAnteriorElemento(hijo){
	return hijo.previousSibling;
}

//Fin JS DOM
//Funciones inputs

//@Descripción: Desactiva el input pasado
//@Params: input (objeto dom)
//@Return: Ninguno
function desactivarInput(input){
	if(!isActivoInput(input))
		input.disabled = true;
}

//@Descripción: Activa el input pasado
//@Params: input (objeto dom)
//@Return: Ninguno
function activarInput(input){
	if(isActivoInput(input))
		input.disabled = false;
}

//@Descripción: Comprueba si esta activo un input
//@Params: input (objeto dom)
//@Return: boolean
function isActivoInput(input) {
	return input.disabled == true;
}

//@Descripción: Comprueba si un input esta vacio
//@Params: input (objeto dom)
//@Return: boolean
function isVacio(input){
	return input.value == "";
}

//Fin funciones inputs
//General

//@Descripción: Obtene la posicion del elemento pasado
//@Params: elemento (objeto dom)
//@Return: integer | false
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