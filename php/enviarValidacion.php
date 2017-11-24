<?php
	if(existeYnoEstaVacio($_GET['id'])){
		
		if(enviarEmail("mcolominasrojas@iesesteveterradas.cat", "www.google.es")){
			echo "enviado";
		}else{
			echo "error al enviar";
		}
	}else{
		
	}

	function existeYnoEstaVacio($variable){
		return (isset($variable) && $variable != "");
	}
	function enviarEmail($para, $link){	
		return mail('mcolominasrojas@iesesteveterradas.cat', 'El título', 'El mensaje');
	}
	//Instalar postfix
?>