

<!DOCTYPE html>
<head>
<meta http-equiv="Content-Type" content="text/html; charset=utf-8">
	<title> GamerZ </title>
	<link rel="stylesheet" media="screen" type="text/css" href="./assets/css/styles.css">
	<script type="text/javascript" src="https://ajax.googleapis.com/ajax/libs/jquery/1.11.1/jquery.min.js"></script>
	<script type="text/javascript" src="./assets/js/jquery.autocomplete.min.js"></script>
	<script type="text/javascript" src="./assets/js/search.js"></script>
	<script src="http://connect.facebook.net/fr_FR/all.js"></script>
	<script type="text/javascript" src="./assets/js/connexion-btn.js"></script>
	<script type="text/javascript" src="./assets/js/resise.js"></script>


</head>
<?php
/* include('/include/connexionFB.php'); */
?>

<body>
<div id="fb-root"></div> <!-- chargé le contenu javascript -->
	<div id="header">
		<div id="content_header">
		 	<div id="connection">
		 		<?php
		 			if(isset($_SESSION['user-pseudo']))
		 			{
			 			echo '<span style="color : white; font-family : AvenirFont; margin-right : 30px;">'.$_SESSION['user-pseudo'].'</span>';
		 			}
		 		?>
		 		<img src="./assets/img/connection.png">
		 		<div id="connexion-pop-up">
		 			<a href="#" id="btn-signout"> <img style="float:right;" src="./assets/img/signout.png"></a>
		 			<form method="post" id="connection-form">
		 				<span id="connection-title"> Connexion </span>
		 				<p><label for="pseudo">Pseudo : </label><input type="text" name="pseudo"></p>
		 				<p><label for="password">Mot de passe :</label> <input type="password" name="password"></p>
		 				<p class="btn-center"> <input class="btn-style" type="submit" value="Se connecter"> </p>
		 			</form>
		 			<form method="post" id="inscription-form" action="">
		 				<span id="connection-title"> Inscription </span>
		 				<p><label for="ins-pseudo">Pseudo : </label><input type="text" name="ins-pseudo"></p>
		 				<p><label for="ins-password">Mot de passe :</label> <input type="password" name="ins-password"></p>
		 				<p class="btn-center"> <input class="btn-style" type="submit" value="S'inscrire"> </p>

		 			</form>

		 			<p class="connexion-inscription-menu"> <span id="connexion-btn"> Connexion </span>  <span id="inscription-btn"> Inscription </a> </span>
		 		</div>


		 	</div>
			<div id="top_barre">
				<div id="logo"> <img src="./assets/img/gamerz.png"> </div>
				<div id="space_1"> </div>
				<div id="search_">

					<form class="form-wrapper" method="post" action="<?php echo $app->urlFor('Game', array('game_id' => 20)); ?>">
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

    <div id="content_top_game">
		<div id="block_left">
    		<div id="content_top_block_left">
					<img src=" ./assets/img/jaquettes/<?php echo Game::getJaquetteName($this->data['BigGame']['id']) ;?>" class="game_img">
	    		<div id="logo_block_left">
						<?php

						foreach(Game::getBrandFromGameWithId($this->data['BigGame']['id']) as $theBrand)
						{
							if(file_exists('./assets/img/'.strtolower($theBrand).'.png'))
							echo '<img src="./assets/img/'.strtolower($theBrand).'.png">';
						}
						?>
					</div>
	    	</div>
	    	<div id="games_name"><?php echo $this->data['BigGame']['name']; ?></div>
	    </div>
	    <div id="block_middle">
	    	<div id="content_top_block_middle"> <?php echo $this->data['BigGame']['name']; ?></div>

		<div id="content_middle_block_middle">
			<?php echo utf8_encode(Game::getGameDescription($this->data['BigGame']['id'])) ?>
		</div>
		<div id="content_bottom_block_middle"><a href="#" class="learnmore"> Learn More </a>
			<?php
			if(count(Game::getGameCategory($this->data['BigGame']['id'])) > 0 )
			{

				foreach(Game::getGameCategory($this->data['BigGame']['id']) as $theGame)
				{
					echo '<a href="#" class="category">'.utf8_encode($theGame).'</a>';

				}
			}
			?>

		</div>

	    </div>

	    <div id="block_right">
	    	<div id="content_top_block_top"> Jeux similaires </div>
	    	<div class="content_middle_block_top_img"> <img src="./assets/img/assasins.png">
	    		<h3>Assassin's Creed IV   Black Flag</h3>
	    	</div>
	    	<div class="content_middle_block_top_img"> <img src="./assets/img/assasins.png">
	    		<h3>Assassin's Creed IV   Black Flag</h3>
	    	</div>
	    	<div class="content_middle_block_top_img"> <img src="./assets/img/assasins.png">
	    		<h3>Assassin's Creed IV   Black Flag</h3>
	    	</div>
	    	<div class="content_middle_block_top_img"> <img src="./assets/img/assasins.png">
	    		<h3>Assassin's Creed IV   Black Flag</h3>
	    	</div>
	    	<div class="content_middle_block_top_img"> <img src="./assets/img/assasins.png">
	    		<h3>Assassin's Creed IV   Black Flag</h3>
	    	</div>
	    	<div class="content_middle_block_top_img"> <img src="./assets/img/assasins.png">
	    		<h3>Assassin's Creed IV   Black Flag</h3>
	    	</div>
		</div>
	</div>





<div id="content_middle">
		<div class="content_middle_left">
			<div class="title_content"> Les plus populaires </div>
			<?php
			foreach ($this->data['PopularGames'] as $game):

			?>

			<div class="block_content_game">
				<div class="block_content_game_img">
					<a href="<?php echo $app->urlFor('Game', array('game_id' => $game['id'])); ?>">
					<img class="block_bottom_game_img" src="./assets/img/jaquettes/<?php echo Game::getJaquetteName($game['id']); ?>"></a>
					<div class="logo_block_bottom">
						<?php
						foreach(Game::getBrandFromGameWithId($game['id']) as $Brand)
						{

							if(file_exists('./assets/img/'.strtolower($Brand).'.png'))
							echo '<img src="./assets/img/'.strtolower($Brand).'.png">';
							else
							echo 'fkjhgfjdks';
						}
						?>
					</div>
				</div>
				<div class="content_middle_title"> <?php echo utf8_encode($game['name']); ?></div>

				<div class="categories">

					<?php
					if(count(Game::getGameCategory($game['id'])) > 0 )
					{

						foreach(Game::getGameCategory($game['id']) as $theGame)
						{
							echo '<a href="#" class="categorie_middle">'.utf8_encode($theGame).'</a>';

						}
					}
					?>
				</div>
			</div>

			<?php
			endforeach;
			?>

		</div>



		<div class="content_middle_right">
				<div class="title_content"> Dernieres sorties </div>

				<?php
				foreach ($this->data['LatestGames'] as $game):

					?>
				<div class="block_content_game">
					<div class="block_content_game_img"> <a href="#"><img class="block_bottom_game_img" src="./assets/img/jaquettes/<?php echo Game::getJaquetteName($game['id']); ?>"></a>
						<div class="logo_block_bottom"><img src="./assets/img/nintendo.png"><img src="./assets/img/windows.png"><img src="./assets/img/ps.png"><img src="./assets/img/xbox.png"></div>
					</div>
					<div class="content_middle_title"> <?php echo utf8_encode($game['name']); ?></div>
					<div class="categories">

						<?php
						if(count(Game::getGameCategory($game['id'])) > 0 )
						{

							foreach(Game::getGameCategory($game['id']) as $theGame)
							{
								echo '<a href="#" class="categorie_middle">'.utf8_encode($theGame).'</a>';

							}
						}
						?>
					</div>
				</div>
				<?php
			endforeach;
			?>
			</div>







	</div>
</body>
