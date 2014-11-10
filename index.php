<?php
require 'vendor/autoload.php';
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
$app->run();
?>