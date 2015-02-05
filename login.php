<?php
	include_once "common/base.php";
	$pageTitle = "Iniciar sesión";
	include_once "common/header.php";
	
	if(!empty($_SESSION['LoggedIn']) && !empty($_SESSION['Username'])):
?>
		<form>
		<p>Actualmente tienes tu <strong>sesión iniciada</strong>.</p>
		</form>
<?php
	elseif(!empty($_POST['username']) && !empty($_POST['password'])):
		include_once 'inc/class.users.inc.php';
		$users = new ElMazoUsers($db);
		if($users->accountLogin()===TRUE):
			echo "<meta http-equiv='refresh' content='0;/'>";
			exit;
		else:
?>
			
			<form method="post" action="login.php" name="loginform" id="loginform">
				<div>
					<h2>Inicio de sesión Fallido&mdash;Intenta nuevamente.</h2>
					<label for="username">Email:</label>
					<input type="text" name="username" id="username" />
					<br />
					<label for="password">Contraseña:</label>
					<input type="password" name="password" id="password" />
					<br />
					<input type="submit" name="login" id="login" value="Iniciar sesión" class="button" />
					<p><a href="/password.php">¿Olvidaste tu contraseña?</a></p>
				</div>
			</form>
<?php
		endif;
	else:
?>
		
		<form method="post" action="login.php" name="loginform" id="loginform">
			<div>
				<h2>Inicia sesión</h2>
				<label for="username">Email:</label>
				<input type="text" name="username" id="username" />
				<br />				
				<label for="password">Contraseña:</label>
				<input type="password" name="password" id="password" />
				<br />
				<input type="submit" name="login" id="login" value="Iniciar sesión" class="button" />
				<p><a href="/password.php">¿Olvidaste tu contraseña?</a></p>
			</div>
		</form>
		
<?php
	endif;
?>

		<div style="clear: both;"></div>
<?php
	include_once 'common/ads.php';
	include_once 'common/footer.php';
?>