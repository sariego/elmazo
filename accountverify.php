<?php
	include_once "common/base.php";
	$pageTitle = "Verifica tu cuenta";
	include_once "common/header.php";
	
	if(isset($_GET['v']) && isset($_GET['e']))
	{
		include_once "inc/class.users.inc.php";
		$users = new ElMazoUsers($db);
		$ret = $users->verifyAccount();
	}
	elseif(isset($_POST['v']))
	{
		include_once "inc/class.users.inc.php";
		$users = new ElMazoUsers($db);
		$ret = $users->updatePassword();
	}
	else
	{
		?><meta http-equiv="refresh" content="0;login.php"><?php
		exit;
	}
	
	if(isset($ret[0])):
		echo isset($ret[1]) ? $ret[1] : NULL;
		
		if($ret[0]<3):
?>
		<form method="post" action="accountverify.php">
			<div>
				<h2>Elige una contraseña</h2>
				<label for="p">Elige una contraseña:</label>
				<input type="password" name="p" id="p" /><br />
				<label for="r">Repite tu contraseña:</label>
				<input type="password" name="r" id="r" /><br />
				<input type="hidden" name="v" value="<?php echo $_GET['v'] ?>" />
				<input type="submit" name="verify" value="Enviar" class="button" />
			</div>
		</form>
<?php
		endif;
	else:
		echo '<meta http-equiv="refresh" content="0;/">';
	endif;
	
	include_once "common/ads.php";
	include_once "common/footer.php";
	
	
	
	