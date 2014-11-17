<?php
require 'vendor/autoload.php';
require 'models/script-functions.php';
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
	$app->render('game-page.html');
	});
	
$app->run();
?>