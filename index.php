<?php
require 'vendor/autoload.php';

include_once 'views/include/cnx.php';
require 'models/script-functions.php';
require 'models/connexion-inscription.php';
require 'models/Game.php';



	$app = new \Slim\Slim();
	// views initiatilisation

	// hook before.router, now $app is accessible in my views
	$app->hook('slim.before.router', function () use ($app) {
		$app->view()->setData('app', $app);
	});

	$view = $app->view();
	$view->setTemplatesDirectory('views');


	$app->get('/', function() use ($app) {
	$popGames =	Game::getGamesByPopularityWithLimit(30);
	$latestGames =	Game::getGamesByDateWithLimit(30);
	$app->render(
	'index.php',
	array(
		"PopularGames" => $popGames,
		"LatestGames" => $latestGames
	)
	);
	});

	$app->get('/game/:game_id', function ($game_id) use ($app) {
		$game = Game::getGame($game_id);
		$jaquette = Game::getJaquetteName($game_id);
		$app->render(
		'game-page.php',
		array(
			"game" => $game,
			"jaquette" => $jaquette
		)
	);
})->name('Game'); // named route so I can use with "urlFor" method

	$app->post('/inscription', function() {
    $app->render('index.php');
	});

$app->run();
?>
