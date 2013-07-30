<?php

use Respect\Rest\Router;
use Respect\Relational\Mapper;

// Step down one dir below "public"
chdir(__DIR__ . '/..');

// Now in the app dir, require the autoload from Composer
require 'vendor/autoload.php';

$mapper = new Mapper(new Pdo('sqlite:datasources/db.sq3'));

$router = new Router();

$router->get('/articles', function () use ($mapper) {
	return [
		'articles' => $mapper->articles->fetchAll()
	];
});

$router->get('/articles/*', function ($articleId) use ($mapper) {
	return [
		'articles' => $mapper->articles[$articleId]->fetchAll()
	];
});

$router->get('/authors', function () use ($mapper) {
	return [
		'authors' => $mapper->authors->fetchAll()
	];
});

$router->always('Accept', [
	'application/json' => 'json_encode', // which function for that mime type
	'text/html' => function ($data) {
		echo '<pre>'; // You can use any template engine here.
		print_r($data);
	}
]);