<?php

/**
 * Handles user interaction within the app
 * 
 * PHP version 5
 * 
 */

 /**
  * 
  */
 class ElMazoUsers 
 {
 	/**
	 * The database object
	 * 
	 * @var object
	 */
	private $_db;
	
	/**
	 * Checks for a database object and creates one if none is found
	 * 
	 * @param object $db
	 * @return void
	 */
     
     public function __construct($db=NULL) 
     {
     	if (is_object($db)) 
     	{
     		$this->_db = $db;			 
		}
		else
		{
			$dsn = "mysql:host=".DB_HOST.";dbname=".DB_NAME;
			$this->_db = new PDO($dsn, DB_USER, DB_PASS);
		}
		          
     }
	 
	 /**
	  * Checks and inserts a new account email into the database
	  * 
	  * @return string		a message indicating the action status
	  */
	 public function createAccount()
	 {
	 	$u = trim($_POST['username']);
		$v = sha1(time());
		
		$sql = "SELECT COUNT(Username) AS theCount
				FROM users
				WHERE Username=:email";
		if($stmt = $this->_db->prepare($sql)) {
			$stmt->bindParam(":email", $u, PDO::PARAM_STR);
			$stmt->execute();
			$row = $stmt->fetch();
			if($row['theCount'!=0]) {
				return "<form><h2> Error </h2>"
					."<p> Lo sentimos, ese correo ya esta siendo utilizado. "
					."Puedes usar otro o <a href=\"password.php\">recuperar tu contraseña</a>. </p></form>";
			}
			if(!$this->sendVerificationEmail($u, $v)) {
				return "<form><h2> Error </h2>"
					."<p> Hubo un error enviando tu correo de verificación. "
					."Puedes <a href=\"mailto:ayuda@elmazo.cl\">contactarnos</a> por soporte. "
					."Disculpa los inconvenientes. </p></form>";
					
			}
			$stmt->closeCursor();
		}
		
		$sql = "INSERT INTO users(Username, ver_code)
				VALUES(:email, :ver)";
		if($stmt = $this->_db->prepare($sql)){
			$stmt->bindParam(":email", $u, PDO::PARAM_STR);
			$stmt->bindParam(":ver", $v, PDO::PARAM_STR);
			$stmt->execute();
			$stmt->closeCursor();
			
			$userID = $this->_db->lastInsertId();
			$url = dechex($userID);
			
			$sql = "INSERT INTO decks(UserID, DeckURL)
					VALUES ($userID, $url)";
			if(!$this->_db->query($sql)) {
				return "<form><h2> Error </h2>"
					."<p> Tu cuenta ha sido creada, pero "
					."tu mazo no ha sido creado </p></form>";
			} else {
				return "<form><h2> ¡Éxito! </h2>"
					."<p> Tu cuenta ha sido creada satisfactoriamente. "
					."Hemos enviado un link de confirmación a <strong>$u</strong>. "
					."¡Revisa tu correo!</p></form>";
			}
			
		} else {
			return "<form><h2> Error </h2>"
				."<p> No se pudo insertar la información "
				."de usuario en la base de datos. </p></form>";
		}
	 }
	 
	 /**
	  * Sends an email to a user with a link to verify their new account
	  * 
	  * @param string $email	The user's email address
	  * @param string $ver		The random verification code for the user
	  * @return boolean			TRUE on success send and FALSE on failure
	  */
	 private function sendVerificationEmail($email, $ver)
	 {
	 	$e = sha1($email);
		$to = trim($email);
		
		$subject = "[elmazo.cl] Verifica tu cuenta!";
		
		$headers = <<<CABEZA
From: elmazo.cl <donotreply@elmazo.cl>
Content-Type: text/plain;
CABEZA;
		$msg = <<<MENSAJE
¡Felicidades!
Tienes una nueva cuenta en elmazo.cl

Para empezar, activa tu cuenta y elige una
contraseña siguiendo el link a continuación.

Tu usuario: $email

Activa tu cuenta: http://www.elmazo.cl/accountverify.php?v=$ver&e=$e

Si tienes cualquier pregunta, contáctanos a ayuda@elmazo.cl.

---

¡Gracias!

www.elmazo.cl
MENSAJE;

		return mail($to, $subject, $msg, $headers);
	 }
	 
	/**
	 * Checks credentials and verifies a user account
	 * 
	 * @return array 	an array containing a status code and status message
	 */
	public function verifyAccount()
	{
		$sql = "SELECT Username
				FROM users
				WHERE ver_code=:ver
				AND SHA1(Username)=:user
				AND verified=0";
		
		if($stmt = $this->_db->prepare($sql))
		{
			$stmt->bindParam(':ver', $_GET['v'], PDO::PARAM_STR);
			$stmt->bindParam(':user', $_GET['e'], PDO::PARAM_STR);
			$stmt->execute();
			$row = $stmt->fetch();
			
			if(isset($row['Username']))
			{
				//Login
				$_SESSION['Username'] = $row['Username'];
				$_SESSION['LoggedIn'] = 1;
			} else {
				return array(4, "<form><h2> Error de verificación </h2>"
					."<p> Esta cuenta ya ha sido verificada. "
					."<a href=\"password.php\">¿Olvidaste tu contraseña?</a></p></form>");
			}
			$stmt->closeCursor();
			
			return array(0, NULL);
			
		}
		else {
			return array(2,  "<form><h2>Error</h2><p>Database Error</p></form>");
		}
	}
	
	/**
	 * Changes the user's password
	 * 
	 * @return boolean	TRUE on success and FALSE on failure
	 */
	public function updatePassword()
	{
		if(isset($_POST['p'])
		&& isset($_POST['r'])
		&& $_POST['p']==$_POST['r'])
		{
			$sql = "UPDATE users
					SET Password=MD5(:pass), verified=1
					WHERE ver_code=:ver
					LIMIT 1";
			
			try
			{
				$stmt = $this->_db->prepare($sql);
				$stmt->bindParam(":pass", $_POST['p'], PDO::PARAM_STR);
				$stmt->bindParam(":ver", $_POST['v'], PDO::PARAM_STR);
				$stmt->execute();
				$stmt->closeCursor();
				
				return TRUE;
			}
			catch (PDOException $e)
			{
				return FALSE;
			}
		} else {
			return FALSE;
		}
	}
	
	/**
	 * Checks credentials and logs in the user
	 * 
	 * @return boolean TRUE on success and FALSE on failure
	 */
	public function accountLogin()
	{
		$sql = "SELECT Username
				FROM users
				WHERE Username=:user
				AND Password=MD5(:pass)
				LIMIT 1";
				
		try
		{
			$stmt = $this->_db->prepare($sql);
			$stmt->bindParam(':user', $_POST['username'], PDO::PARAM_STR);
			$stmt->bindParam(':pass', $_POST['password'], PDO::PARAM_STR);
			$stmt->execute();
			if($stmt->rowCount()==1)
			{
				$_SESSION['Username'] = htmlentities($_POST['username'], ENT_QUOTES);
				$_SESSION['LoggedIn'] = 1;
				return TRUE;
			}
			else
			{
				return FALSE;
			}
		}
		catch(PDOException $e)
		{
			return FALSE;
		}
	}
	
	/**
	 * Retrieves the ID and verification code of an user
	 * 
	 * @return mixed	an array of info or FALSE on failure
	 */
	public function retrieveAccountInfo()
	{
		$sql = "SELECT UserID, ver_code
				FROM users
				WHERE Username=:user";
		
		try
		{
			$stmt = $this->_db->prepare($sql);
			$stmt->bindParam(':user', $_SESSION['Username'], PDO::PARAM_STR);
			$stmt->execute();
			$row = $stmt->fetch();
			$stmt->closeCursor();
			return array($row['UserID'], $row['ver_code']);
		}
		catch(PDOException $e)
		{
			return FALSE;
		}
	}
	
	/**
	 * Changes the user's email address
	 * 
	 * @return boolean	TRUE on success and FALSE on failure
	 */
	public function updateEmail()
	{
		$sql = "UPDATE users
				SET Username=:email
				WHERE UserID=:user
				LIMIT 1";
		try
		{
			$stmt = $this->_db->prepare($sql);
			$stmt->bindParam(':email', $_POST['username'], PDO::PARAM_STR);
			$stmt->bindParam(':user', $_POST['user-id'], PDO::PARAM_INT);
			$stmt->execute();
			$stmt->closeCursor();
			
			$_SESSION['Username'] = htmlentities($_POST['username'], ENT_QUOTES);
			
			return TRUE;
		}
		catch(PDOException $e)
		{
			return FALSE;
		}
	}
	
	/**
	 * Deletes an account and all associated items
	 * 
	 * @return boolean	TRUE on success and FALSE on failure
	 */
	public function deleteAccount()
	{
		if(isset($_SESSION['LoggedIn']) && $_SESSION['LoggedIn'] == 1)
		{
			// Delete user's deck(s)
			$sql = "DELETE FROM decks
					WHERE UserID=:user";
			
			try
			{
				$stmt = $this->_db->prepare($sql);
				$stmt->bindParam(':user', $_POST['user-id'], PDO::PARAM_INT);
				$stmt->execute();
				$stmt->closeCursor();
			}
			catch(PDOException $e)
			{
				die($e->getMessage());
			}
			
			//Delete user
			$sql = "DELETE FROM users
					WHERE UserID=:user
					AND Username=:email";
			
			try
			{
				$stmt = $this->_db->prepare($sql);
				$stmt->bindParam(':user', $_POST['user-id'], PDO::PARAM_INT);
				$stmt->bindParam(':email', $_POST['username'], PDO::PARAM_STR);
				$stmt->execute();
				$stmt->closeCursor();
			}
			catch(PDOException $e)
			{
				die($e->getMessage());
			}
			
			// Destroy user's session
			unset($_SESSION['Loggedin'], $_SESSION['Username']);
			header("Location: /gone.php");
			exit;
		}
		else
		{
			header("Location: /account?delete=failed");
			exit;
		}
	}

	/**
	 * Resets a user's status to unverified and sends them an email
	 * 
	 * @return mixed	TRUE on success and a message on failure
	 */
	public function resetPassword()
	{
		$v = sha1(time());
		
		$sql = "UPDATE users
				SET ver_code=:ver, verified=0
				WHERE Username=:user
				LIMIT 1";
				
		try
		{
			$stmt = $this->_db->prepare($sql);			
			$stmt->bindParam(':ver', $v, PDO::PARAM_STR);
			$stmt->bindParam(':user', $_POST['username'], PDO::PARAM_STR);
			$stmt->execute();
			$stmt->closeCursor();
		}
		catch(PDOException $e)
		{
			return $e->getMessage();
		}
		
		// Send email
		if($this->sendResetEmail($_POST['username'], $v))
		{
			return "Error en el envío del correo";
		}
		return TRUE;
	}
	
	/**
	  * Sends an email to a user with a link to verify their new account
	  * 
	  * @param string $email	The user's email address
	  * @param string $ver		The random verification code for the user
	  * @return boolean			TRUE on success send and FALSE on failure
	  */
	 private function sendResetEmail($email, $ver)
	 {
	 	$e = sha1($email);
		$to = trim($email);
		
		$subject = "[elmazo.cl] Restablece tu contraseña!";
		
		$headers = <<<CABEZA
From: elmazo.cl <donotreply@elmazo.cl>
Content-Type: text/plain;
CABEZA;
		$msg = <<<MENSAJE
Hola,
Escuchamos que olvidaste tu contraseña, para restablecerla
sigue el siguiente link:

http://www.elmazo.cl/accountverify.php?v=$ver&e=$e

Si tienes cualquier pregunta, contáctanos a ayuda@elmazo.cl.

---

¡Gracias!

www.elmazo.cl
MENSAJE;

		return mail($to, $subject, $msg, $headers);
	 }
}


?>

 
 
 
 
 