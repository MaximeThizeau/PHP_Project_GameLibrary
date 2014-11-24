	<div id="AjaxContent">
		<ul id="onglets">
			<li class="actif"><img src="./assets/img/description-menu.png">Description <span class="border-menu">|</span></li>
			<li><img src="./assets/img/actualites-menu.png">Actualités </a><span class="border-menu">|</span></li>
			<li><img src="./assets/img/test-menu.png">Tests </a><span class="border-menu">|</span></li>
			<li><img src="./assets/img/image-menu.png"> Images </a><span class="border-menu">|</span></li>
			<li><img src="./assets/img/avis-menu.png"> Avis </a> <span class="border-menu">|</span></li>
			<li class="buy-menu"><img src="./assets/img/acheter-menu.png"> Acheter </a></li>
		</ul>

		<div id="Ajax">

			<div class="item">
				<?php include('./views/ContentAjax/description.php'); ?>
			</div>

			<div class="item">
				<?php include('./views/ContentAjax/actualites.php'); ?>
			</div>

			<div class="item">
				<?php include('./views/ContentAjax/tests.php'); ?>
			</div>

			<div class="item">
				<?php include('./views/ContentAjax/images.php'); ?>
			</div>

			<div class="item">
				<?php include('./views/ContentAjax/avis.php'); ?>
			</div>

			<div class="item">
				<?php include('./views/ContentAjax/acheter.php'); ?>
			</div>
		</div>
	</div>
