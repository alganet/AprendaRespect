<?php

use Respect\Rest\Router;
use Respect\Relational\Mapper;
use Respect\Validation\Validator as v;

require __DIR__.'/../bootstrap.php';

$mapper = new Mapper(new Pdo('sqlite:datasources/db.sq3'));
$validatorId = v::int()->min(1, true);
$router = new Router();
$router->get('/', function() { header('Location: /articles'); });
$router->get('/articles', function () use ($mapper) {
	return [
		'articles' => $mapper->articles->fetchAll()
	];
});

$router->get('/articles/*', function ($articleId) use ($mapper) {
	return [
		'articles' => $mapper->articles[$articleId]->fetchAll()
	];
})->when(function($articleId) use ($validatorId) {
    return $validatorId->validate($articleId);
});

$router->get('/authors', function () use ($mapper) {
	return [
		'authors' => $mapper->authors->fetchAll()
	];
});
$router->get('/authors/*', function ($authorId) use ($mapper) {
	return [
		'authors' => $mapper->authors[$authorId]->fetchAll()
	];
})->when(function($authorId) use ($validatorId) {
    return $validatorId->validate($authorId);
});

$router->always('Accept', [
	'application/json' => 'json_encode', // which function for that mime type
	'text/html' => function ($data) {
		echo '<pre>'; // You can use any template engine here.
		print_r($data);
	}
]);
