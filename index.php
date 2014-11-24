<?php
require 'vendor/autoload.php';
require 'models/script-functions.php';
require 'models/connexion-inscription.php';
	$app = new \Slim\Slim();
	// views initiatilisation
	$view = $app->view();
	$view->setTemplatesDirectory('views');
	$app->get('/hello/:name', function ($name)
	{
	echo "Hello, $name";
	});
	$app->get('/', function() use ($app) {
	$app->render('index.php');
	});

	$app->get('/game', function() use ($app) {
	$app->render('game-page.php');
	});

	$app->post('/inscription', function() {
    $app->render('index.php');
	});

$app->run();
?>
