<?php
	//set the error reporting level
	error_reporting(E_ALL);
	ini_set("display_errors", 1);
	
	//start a PHP session
	session_start();
	
	//include site constants
	include_once 'inc/constants.inc.php';
	
	//create a database object
	try {
		$dsn = "mysql:host=".DB_HOST.";dbname=".DB_NAME;
		$db = new PDO($dsn, DB_USER, DB_PASS);
		$db->exec('SET CHARACTER SET utf8');
	} catch (PDOException $e) {
		echo 'Connection Failed: ' . $e->getMessage();
		exit;
	}
?>
