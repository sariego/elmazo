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
	
	private $transFrequency = array(1 => 'Ultrareal', 'Milenaria', 'Real', 'Cortesano', 'Vasallo', 'Sin Frecuencia');
	private $transType = array('Oro', 'Aliado', 'Talismán', 'Arma', 'Tótem');
	private $transRace = array(1 => 'Caballero', 'Eterno', 'Guerrero', 'Bestia');
	
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
	 	$sql = "SELECT * FROM cards";
		
		foreach ($this->_db->query($sql) as $row)
		{
			$cardImgSrc = 		"img/cards/".$row['EdNumber'].".jpg";
			$cardName = 		$row['Name'];
			$cardFrequency = 	$this->transFrequency[$row['Frequency']];
			$cardType =			$this->transType[$row['Type']];
			$cardCost = 		isset($row['Cost']) ? $row['Cost'] : "&mdash;";
			$cardStrength = 	isset($row['Strength']) ? $row['Strength'] : "&mdash;";
			$cardRace = 		isset($row['Race']) ? $this->transRace[$row['Race']] : "&mdash;";
			$cardIsUnique = 	$row['isUnique'];
			$cardIllustrator = 	$row['Illustrator'];
			$cardAbility =		$row['Ability'];
			
			$textToShow = "<b>Frecuencia:</b> $cardFrequency<br/>"
				."<b>Tipo:</b> $cardType<br/>"
				."<b>Raza:</b> $cardRace<br/>"
				."<b>Coste:</b> $cardCost<br/>"
				."<b>Fuerza:</b> $cardStrength<br/>"
				."<b>Habilidad:</b><br/>$cardAbility<br/>"
				."<br/><br/><b>Ilustrador:</b>$cardIllustrator<br/>";
			
			$textToEnter = <<<CARTA
<li>
	<img src="$cardImgSrc" width="100" height="144" />
	<span class="text-content_a">
		<span>
			<a ><i class="fa fa-plus"></i></a>
		</span>
		<span>
			<a href="#"><i class="fa fa-minus"></i></a>
		</span>
		<span>
			<a onclick="setModalLabel('$cardName', '$cardImgSrc', '$textToShow')" data-toggle="modal" data-target="#cardModal"><i class="fa fa-info"></i></a>
		</span>
	</span>
</li>
CARTA;
			
			echo $textToEnter;
		}
	 }
 }

 
 
 
 
 
 
 
 
 
 
 
 