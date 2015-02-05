<?php
    include_once "common/base.php";

    if(isset($_POST['v']))
    {
        include_once "inc/class.users.inc.php";
        $users = new ElMazoUsers($db);
        $status = $users->updatePassword() ? "changed" : "failed";
        header("Location: /account.php?password=$status");
        exit;
    }
	
    $pageTitle = "Restablece tu contraseña";
    include_once "common/header.php";

?>

        <h2>Restablece tu contraseña</h2>

        <form method="post" action="resetpassword.php">
            <div>
                <label for="p">Elige una nueva contraseña:</label>
                <input type="password" name="p" id="p" /><br />
                <label for="r">Repetir nueva contraseña:</label>
                <input type="password" name="r" id="r" /><br />
                <input type="hidden" name="v" value="<?php echo $_GET['v'] ?>" />
                <input type="submit" name="verify" id="verify" value="Restablecer contraseña" />
            </div>
        </form>

<?php

    include_once("common/ads.php");
    include_once 'common/footer.php';
?>