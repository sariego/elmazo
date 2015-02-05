<?php
	include_once 'common/base.php';
	$pageTitle = 'Restablecer contraseña';
	include_once 'common/header.php';
?>

<form method="post" action="db-interaction/users.php">
	<div>
		<h2>Restablece tu contraseña</h2>
		<p>Ingresa el correo electrónico que usas para ingresar 
			y te enviaremos un link para restablecer tu contraseña.</p>
		<br /><br />
		<input type="hidden" name="action" value="resetpassword" />
		<label for="username">Email:</label>
		<input type="text" name="username" id="username" />
		<input type="submit" name="reset" id="reset" value="Enviar" class="button" />
	</div>	
</form>
<?php
	include_once 'common/ads.php';
	include_once 'common/footer.php'
?>
