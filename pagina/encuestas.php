<!DOCTYPE html>
<html>
<head>
    <meta charset="utf-8">
    <link rel="stylesheet" type="text/css" href="../css/main.css" />
	<title></title>
	<script type="text/javascript" src="../js/validacionEncuesta.js"></script>
	<style>

	</style>
</head>
<body onload="inicializar()">
	<form action="../php/encuestas.php">
		<div id="dataInicio">
			<div class="tooltip"><input type="number" name="diaInicio" placeholder="DD"></div>
			<div class="tooltip"><input type="number" name="mesInicio" placeholder="MM"></div>
			<div class="tooltip"><input type="number" name="anyInicio" placeholder="YYYY"></div>
		</div>
		<div id="dataFin">
			<div class="tooltip"><input type="number" name="diaFin" placeholder="DD"></div>
			<div class="tooltip"><input type="number" name="mesFin" placeholder="MM"></div>
			<div class="tooltip"><input type="number" name="anyFin" placeholder="YYYY"></div>
		</div>
		<div class="tooltip"><input id="pregunta" type="input" name="pregunta"></div>
		<input id="crearForumario" type="submit">
		<button id="addRespuesta" type="button">Crear otra respuesta</button>
		<button id="removeRespuesta" type="button">Eliminar todas las respuestas</button>
		<div id="respuestas"></div>
	</form>
</body>
</html>
