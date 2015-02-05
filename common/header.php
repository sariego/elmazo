<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
    <meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
    <title>Elmazo.cl | <?php echo $pageTitle ?> </title>
    <link href='http://fonts.googleapis.com/css?family=Open+Sans' rel='stylesheet' type='text/css'>
    <link rel="stylesheet" href="//maxcdn.bootstrapcdn.com/font-awesome/4.3.0/css/font-awesome.min.css">
    <link href="css/elmazo.css" rel="stylesheet" type="text/css" />
    <link rel="icon" type="image/x-icon" href="http://www.elmazo.cl/favicon.ico" />
</head>
    <div id="header">
        <a href="/"><img src="img/header.png" style='width:100%;' border="0" alt="Null"></a>        
        
		<?php
			if(isset($_SESSION['LoggedIn']) && isset($_SESSION['Username']) && $_SESSION['LoggedIn'] == 1):
		?>
		<ul>
            <li><i class="fa fa-sign-out"></i><a href="logout.php">Cerrar Sesión</a></li>
        </ul>
        <?php else: ?>
		<ul>
            <li><i class="fa fa-sign-in"></i><a href="login.php">Iniciar Sesión</a></li>
            <li>|</li>
            <li><i class="fa fa-pencil-square-o"></i><a href="signup.php">Regístrate</a></li>
        </ul>        
        <?php endif; ?>     
    </div>