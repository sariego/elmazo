<?php 
include_once "common/base.php";
$pageTitle = '¡Arma tu mazo!';
include_once "common/header.php"; 
?>

<script src="js/cards.js"></script>


<div id="sidebar">
    <ul>
        <li><i class="fa fa-user fa-2x"></i><a href="#"><?php echo $_SESSION['Username']; ?></a></li>
        <li><i class="fa fa-cog fa-2x"></i><a href="#">Opciones</a></li>
    </ul>
    <div class="section">
        <h1>Mazos<i class="fa fa-cube fa-lg"></i></h1>
    </div>
    <!--LISTA DE MAZOS, MOSTRAR SOLO CUANDO ESTEN CREADAS-->
    <ul>
        <li><i class="fa fa-cube"></i><a >El Mazo</a></li>
    </ul>
    <!--FIN LISTA DE MAZOS-->
    <!--BOTON PARA AGREGAR MAZOS-->
    <div id="add_deck">
        <ul>
            <li><i class="fa fa-plus"></i><a >Agregar Mazo</a></li>
        </ul>
    </div>
    <!--FIN BOTON PARA AGREGAR MAZOS-->
    <!--SECCION DE ESTADISTICAS, ESTAS SE ACTUALIZAN A MEDIDA QUE SE AGREGAN LOS DIFERENTES TIPOS DE CARTAS AL MOMENTO DE CREAR AL MAZO-->
    <div class="section">
        <h1>Estadísticas<i class="fa fa-pie-chart fa-lg"></i></h1>
    </div>
    <div id="stats">
        <ul>
            <li><i class="fa fa-male fa-lg fa-fw"></i>Aliados: <!--NUMERO DE ALIADOS EN EL MAZO--></li>
            <li><i class="fa fa-diamond fa-lg fa-fw"></i>Talismanes: <!--NUMERO DE TALISMANES EN EL MAZO--></li>
            <li><i class="fa fa-gavel fa-lg fa-fw"></i>Armas: <!--NUMERO DE ARMAS EN EL MAZO--></li>
            <li><i class="fa fa-university fa-lg fa-fw"></i>Totems: <!--NUMERO DE TOTEMS EN EL MAZO--></li>
            <li><i class="fa fa-circle fa-lg fa-fw"></i>Oros: <!--NUMERO DE OROS EN EL MAZO--></li>
        </ul>
    </div>
    <!--FIN ESTADISTICAS-->
</div>
<div id="cards_catalogue">
<div class="section">
        <h1>Cartas<i class="fa fa-cube fa-lg"></i></h1>
    </div>
    <ul id="all_filters">
    	<li>
    		<div id="cards">
        		<!--FILTRO DE CARTAS POR TIPO-->
        		<ul class="img-list">
            		<li>
                		<!--ESTE LINK FILTRA ALIADOS-->
                		<a href="?type=1">	
                    		<img src="img/aliados.png" width="50" height="65" />
                    		<span class="text-content"><span>Aliados</span></span>
		                </a>
        		    <!--FIN FILTRO ALIADOS-->
		            </li>
            		<li>
            		<!--ESTE LINK FILTRA TALISMANES-->
                		<a href="?type=2">
                    		<img src="img/talisman.png" width="50" height="65" />
                    		<span class="text-content"><span>Talismanes</span></span>
                		</a>
                		<!--FIN FILTRO TALISMANES-->
            		</li>
            		<li>
                		<!--ESTE LINK FILTRA ARMAS-->
                		<a href="?type=3">
                    		<img src="img/arma.png" width="50" height="65" />
                    		<span class="text-content"><span>Armas</span></span>
                		</a>
                		<!--FIN FILTRO ARMAS-->
            		</li>
            		<li>
                		<!--ESTE LINK FILTRA TOTEMS-->
                		<a href="?type=4">
                    		<img src="img/totem.png" width="50" height="65" />
                    		<span class="text-content"><span>Totems</span></span>
                		</a>
                		<!--FIN FILTRO TOTEMS-->
            		</li>
            		<li>
                		<!--ESTE LINK FILTRA OROS-->
                		<a href="?type=0">
                    		<img src="img/oro.png" width="50" height="65" />
                    		<span class="text-content"><span>Oros</span></span>
                		</a>
                		<!--FIN FILTRO OROS-->
            		</li>
        		</ul>
        		<!--FIN FILTRO CARTAS POR TIPO-->
    		</div>
    	</li>
    	<li>
    				<!--BUSCADOR DE CARTAS POR NOMBRE O HABILIDAD--->
    		<form id="filter" >
        		<label for="search">Buscar<i class="fa fa-search"></i></label>
				<input type="text" name="search" id="search_input" placeholder="Buscar por nombre o habilidad..."/>
    		</form>
    		<!--FIN BUSCADOR DE CARTAS-->
    	</li>
    	<li>
    		<a href="?search="><button>Quitar Filtros</button></a>
    	</li>
    </ul>
    
    
    
    
    <div id="cards">
        <!--LISTADO COMPLETO DE CARTAS-->
        <ul class="img-list_a" id="cardListBlock">
            <?php
			include_once "inc/class.decks.inc.php";
			$cards = new ElMazoDecks($db);
			echo $cards->loadCardList();
			?>
        </ul>
        <!--FIN LISTADO COMPLETO DE CARTAS-->
    </div>
</div>    
<div id="deck">
    <div class="section">
        <h1>El Mazo<i class="fa fa-cube fa-lg"></i></h1>
    </div>
    <div id="cards">
        <ul class="img-list_a">
            <li>
                    <img src="img/expansionmyl/EF-01-90.jpg" width="100" height="144" />
                    <span class="text-content_a">
                        <span>
                            <i class="fa fa-plus"></i>
                        </span>
                        <span>
                            <i class="fa fa-minus"></i>
                        </span>
                        <span>
                            <a data-toggle="modal" data-target="#myModal"><i class="fa fa-info"></i></a>
                        </span>
                    </span>
                    
            </li>
        </ul>
    </div>
</div>
<!--ACA COMIENZA LA DESCRIPCIÓN DE CADA CARTA-->
<div class="modal fade" id="cardModal" tabindex="-1" role="dialog" aria-labelledby="cardModalLabel" aria-hidden="true">
	<div class="modal-dialog">
		<div class="modal-content">
			<div class="modal-header">
				<button type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">&times;</span></button>
				<!--TITULO/NOMBRE DE LA CARTA SELECCIONADA-->
				<h4 class="modal-title" id="cardModalLabel">lala</h4>
				<!--FIN TITULO/NOMBRE-->
			</div>
			<div class="modal-body">
				<!--IMAGEN AMPLIADA CARTA SELECCIONADA--> 
				<img id="cardModalImg"src="img/expansionmyl/EF-01-90.jpg">
				<!--FIN IMAGEN AMPLIADA-->
				<!--DESCRIPCIÓN DE LA CARTA-->
				<p id="cardModalText">Lorem ipsum dolor sit amet, consectetur adipiscing elit. Aenean posuere pulvinar risus nec facilisis. Aenean facilisis risus sit amet sem viverra malesuada. Nulla eu lorem a eros tempor vulputate sit amet ut felis. Morbi dui neque, posuere a sagittis vel, placerat et lacus.</p>
				<!--FIN DESCRIPCIÓN CARTA-->
			</div>
		</div>
	</div>
</div>

