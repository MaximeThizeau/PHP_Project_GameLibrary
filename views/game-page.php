<!DOCTYPE html>
<head>
<meta http-equiv="Content-Type" content="text/html; charset=utf-8">
	<title> GamerZ </title> 
	<link rel="stylesheet" media="screen" type="text/css" href="./assets/css/styles.css">
	<script type="text/javascript" src="https://ajax.googleapis.com/ajax/libs/jquery/1.11.1/jquery.min.js"></script>
	<script type="text/javascript" src="./assets/js/jquery.autocomplete.min.js"></script>
	<script type="text/javascript" src="./assets/js/search.js"></script>
	<script type="text/javascript" src="./assets/js/AjaxPageGame.js"></script>
</head>


<body>

<div id="fb-root"></div>
<script>(function(d, s, id) {
  var js, fjs = d.getElementsByTagName(s)[0];
  if (d.getElementById(id)) return;
  js = d.createElement(s); js.id = id;
  js.src = "//connect.facebook.net/en_US/sdk.js#xfbml=1&version=v2.0";
  fjs.parentNode.insertBefore(js, fjs);
}(document, 'script', 'facebook-jssdk'));</script>


	<div id="header">
		<div id="content_header">
		 	<div id="connection"> <img src="./assets/img/connection.png"> </div>
			<div id="top_barre">
				<div id="logo"> <a href="./"><img src="./assets/img/gamerz.png"></a> </div>
				<div id="space_1"> </div>
				<div id="search_"> 
					<form class="form-wrapper" method="post">
					<div class="btn-left-loupe"></div>
					<input class="search_data" name="saisie" type="text" id="search" placeholder="Mots-Clefs..." />
					<button type="submit">Search</button>
					</form>
				</div>
				<div id="menu">
					<ul>
	                    <li>
	                        <a href="#">Discovers</a>
	                    </li>
	                </ul>
	                <div id="space_3"> </div>
	                <ul>
	                    <li>
	                        <a href="#">Plateforms</a>
	                    </li>
	                </ul>
	            </div>
	           
	        </div>
	    </div>
    </div>


    <div id="corps-game">
    	<div id="corps-game-block-left">
    		<img src="./assets/img/assasins.png" class="corps-game-img">
    		<div id="content-block-left">
    			<div id="block-left-block-title">
    				<h1> Assassin's Creed IV - Black Flag </h1>
    				<p class="liste-consoles"><strong>Consoles :</strong> PC, PS4, PS3, Xbox One, Xbox 360, Wii, Wii U, Nintendo 3DS</p> <br>
    				<p class="note-block-title"> Note : 18/20</p>
    			</div>
    		</div>
	    		
    	</div>
    	<div id="corps-game-block-right">
	    	<div id="menu-game">
	    		<ul>
	    			<li><img src="./assets/img/description-menu.png"><a href="description.php"> Description </a></li><span class="border-menu">|</span>
	    			<li><img src="./assets/img/actualites-menu.png"><a href="actualites.php"> Actualités </a></li><span class="border-menu">|</span>
	    			<li><img src="./assets/img/test-menu.png"><a href="tests.php"> Tests </a></li><span class="border-menu">|</span>
	    			<li><img src="./assets/img/image-menu.png"><a href="images.php"> Images </a></li><span class="border-menu">|</span>
	    			<li><img src="./assets/img/avis-menu.png"><a href="avis.php"> Avis </a></li><span class="border-menu">|</span>
	    			<li class="buy-menu"><img src="./assets/img/acheter-menu.png"><a href="acheter.php"> Acheter </a></li>

	    		</ul>
	    	</div>

<div id="contenu">
<?php
$d="./views/ContentAjax/";
	if(isset($_GET['p']))
		{
			$p=strtolower($_GET['p']);
			if(preg_match("/^[a-z0-9\-]+$/",$p) && file_exists($d.$p.".html"))
				{
				include $d.$p.".html";
				}
			else
				{
					include $d."404.html";
				}
		}
	else
	{
		include $d."description.php";
	}
?>
</div>
	    	<div class="separateur-block"></div>




	    </div>
	    	
	    	
	    	
	    	
	    	
    </div>
    	
    	
    	
    	
    </div>

    	
</body>		