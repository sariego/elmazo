<?php
	include_once "common/base.php";
	if(isset($_SESSION['LoggedIn']) && $_SESSION['LoggedIn'] == 1):
		$pageTitle = 'Tu cuenta';
		include_once "common/header.php";
		include_once 'inc/class.users.inc.php';
		$users = new ElMazoUsers($db);
		
		if(isset($_GET['email']) && $_GET['email'] == 'changed')
		{
			echo "<div class='message good'>Tu email ha sido cambiado con éxito.</div>";
		}
		elseif(isset($_GET['email']) && $_GET['email'] == 'failed')
		{
			echo "<div class='message bad'>Oops! Hubo un problema cambiando tu email.</div>";
		}
		
		if(isset($_GET['password']) && $_GET['password'] == 'changed')
		{
			echo "<div class='message good'>Tu contraseña ha sido cambiada con éxito.</div>";
		}
		elseif(isset($_GET['password']) && $_GET['email'] == 'nomatch')
		{
			echo "<div class='message bad'>Las contraseñas no coinciden. Intenta nuevamente.</div>";
		}
		
		if(isset($_GET['delete']) && $_GET['delete'] == 'failed')
		{
			echo "<div class='message bad'>Oops! Hubo un problema eliminando tu cuenta.</div>";
		}
		
		list($userID, $v) = $users->retrieveAccountInfo();
?>
		
		<form method="post" action="db-interaction/users.php" id="change-email-form">
			<div>
				<h2>Tu cuenta</h2>
				<input type="hidden" name="user-id" value="<?php echo $userID ?>" />
				<input type="hidden" name="action" value="changeemail" />
				<label for="username">Cambiar email:</label>
				<input type="text" name="username" id="username" />
				<br />
				<input type="submit" name="change-email-submit" id="change-email-submit" value="Cambiar email" class="button" />
			</div>
		</form>
		<br /><br />
		
		<form method="post" action="db-interaction/users.php" id="change-password-form">
			<div>
				<input type="hidden" name="user-id" value="<?php echo $userID ?>" />
				<input type="hidden" name="v" value="<?php echo $v ?>" />
				<input type="hidden" name="action" value="changepassword" />
				<label for="new-password">Nueva contraseña:</label>
				<input type="password" name="p" id="new-password" />
				<br />
				<label for="repeat-password">Repetir nueva contraseña:</label>
				<input type="password" name="r" id="repeat-password" />
				<br />
				<input type="submit" name="change-password-submit" id="change-password-submit" value="Cambiar contraseña" class="button" />
			</div>
		</form>
		<br /><hr />
		
		<form method="post" action="deleteaccount.php" id="delete-account-form">
			<div>
				<input type="hidden" name="user-id" value="<?php echo $userID ?>" />
				<input type="submit" name="delete-account-submit" id="delete-account-submit" />
			</div>
		</form>
<?php

	else:
		?><meta http-equiv="refresh" content="0;/" /><?php
		exit;
	endif;
?>

<div class="clear"></div>

<?php
	include_once "common/ads.php";
	include_once 'common/footer.php';
?>
		
		
