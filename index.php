<?php
ini_set('display_errors','on');
error_reporting(E_ALL);
require 'vendor/autoload.php';
$router = new App\Router\Router($_GET['url']);

$router->get('/', function(){ echo 'Accueil'; },'Accueil');
$router->get('/posts', function(){ echo 'Tous les articles'; }, 'posts.index');
$router->get('/posts/:slug-:id','Posts.show','posts.show')->with('id', '[0-9]+')->with('slug', '[a-z\-0-9]+');
$router->get('/posts/:id', 'Posts.show', 'Article ');
$router->post('/posts/:id', function($id){ echo 'Poster l\'articles ' . $id; }, 'posts.create');

$router->run();