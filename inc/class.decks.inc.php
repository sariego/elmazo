<?php

/**
 * Handles deck interaction within the app
 * 
 * PHP version 5
 * 
 */

 /**
  * 
  */
class ElMazoDecks
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
	  * Loads the complete card list
	  * 
	  * This function both outputs <li> tags with the cards and all its data.
	  * 
	  * @return void
	  */
	 public function loadCardList()
	 {
	 	$sql = "SELECT * FROM cards LIMIT 3";
		
		foreach ($this->_db->query($sql) as $row)
		{
			$imgSrc = "img/cards/".$row['EdNumber'].".jpg";
			$textToEnter = <<<CARTA
<li>
	<img src="$imgSrc" width="100" height="144" />
	<span class="text-content_a">
		<span>
			<a href="#"><i class="fa fa-plus">
		</span>
		<span>
			<a href="#"><i class="fa fa-minus"></i></a>
		</span>
		<span>
			<a data-toggle="modal" data-target="#myModal"><i class="fa fa-info"></i></a>
		</span>
	</span>
</li>
CARTA;
			
			echo $textToEnter;
		}
	 }
 }

 
 
 
 
 
 
 
 
 
 
 
 