<?php $classActive = "" ?>
<ul id="menu">
	<li> <!-- Lado izquierdo -->
		<ul>
			<li><span>Menú:</span></li>
			<?php paginaActiva("index.php", $classActive); ?>
			<li><a <?php echo $classActive ?> href="<?php echo getURLAbsolute(); ?>index.php">Inicio</a></li>

			<?php if(existeYnoEstaVacio($_SESSION['usuario'])){ ?>
				<?php paginaActiva("pagina/crearEncuesta.php", $classActive); ?>
				<li><a <?php echo $classActive ?> href="<?php echo getURLAbsolute(); ?>pagina/crearEncuesta.php">Crear una encuesta</a></li>
				<?php paginaActiva(["pagina/mostrarEncuesta.php", "pagina/votarEncuesta.php"], $classActive); ?>
				<li><a <?php echo $classActive ?> href="<?php echo getURLAbsolute(); ?>pagina/mostrarEncuesta.php">Ver/Votar encuestas</a></li>
			<?php } ?>
		</ul>
	</li>
	<li> <!-- Lado derecho -->
		<ul>
			<?php if(existeYnoEstaVacio($_SESSION['usuario'])){ ?>
				<li class="dropdown">
					<?php paginaActiva(["pagina/cambiarPassword.php", "pagina/perfil.php"], $classActive); ?>
					<input type="radio" id="submenu1">
					<label for="submenu1" <?php echo $classActive ?>><?php echo $_SESSION['usuario']['email'] ?> <i class="fa fa-caret-down"></i></label>
					<div>
						<?php paginaActiva("pagina/perfil.php", $classActive); ?>
						<a <?php echo $classActive ?> href="<?php echo getURLAbsolute(); ?>pagina/perfil.php">Perfil</a>
						<?php paginaActiva("pagina/cambiarPassword.php", $classActive); ?>
						<a <?php echo $classActive ?> href="<?php echo getURLAbsolute(); ?>pagina/cambiarPassword.php">Cambiar Contraseña</a>
						<a href="<?php echo getURLAbsolute(); ?>php/cerrarSession.php">Cerrar Sessión</a>
					</div>
				</li>
			<?php }else{ ?>
				<?php paginaActiva("pagina/login.php", $classActive); ?>
				<li><a <?php echo $classActive ?> href="<?php echo getURLAbsolute(); ?>pagina/login.php">Login</a></li>
				<?php paginaActiva("pagina/registro.php", $classActive); ?>
				<li><a <?php echo $classActive ?> href="<?php echo getURLAbsolute(); ?>pagina/registro.php">Registrase</a></li>
			<?php } ?>
		</ul>
	</li>
</ul>



<?php
	function paginaActiva($url, &$variable){
		if(is_array($url)){
			$variable = '';
			foreach ($url as $value) {
				if(strpos(getCurrentPage(), "/".getURLcartepa().$value) !== false ){
					$variable = 'class="active"';
					break;
				}
			}
		}else{
			if(strpos(getCurrentPage(), "/".getURLcartepa().$url) !== false) $variable = 'class="active"';
			else $variable = '';
		}
	}
?>
