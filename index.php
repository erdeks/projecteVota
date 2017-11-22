<?php session_start();?>
<!DOCTYPE html>
<html>
<head>
	<meta charset="UTF-8">
	<title>MySQL PDO</title>
</head>
<body>
	<a href="pagina/login.php">login</a>
	<a href="pagina/registro.php">registro</a>

	
	<?php
		if(isset($_GET['remove'])){
			unset($_SESSION['usuario']);
			header("Location: index.php");
		}
		if(isset($_SESSION['usuario'])){
			echo '<a href="index.php?remove=true">Cerrar cuenta</a>';
		}

	?>
</body>
</html>