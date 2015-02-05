<?php
	include_once 'common/base.php';
	$pageTitle = "Regístrate";
	include_once 'common/header.php';
	
	if(!empty($_POST['username'])):
		include_once 'inc/class.users.inc.php';
		$user = new ElMazoUsers($db);
		echo $user->createAccount();
	else:
?>

		
		<form method="post" action="signup.php" id="registerform">
			<div>
				<h2>Regístrate</h2>
				<label for="username">Email:</label>
				<input type="text" name="username" id="username" /><br />
				<input type="submit" name="register" id="register" value="Regístrate" class="button"/>
			</div>
		</form>

<?php
	endif;
	include_once 'common/ads.php';
	include_once 'common/footer.php';
?>