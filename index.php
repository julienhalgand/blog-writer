<?php
ini_set('display_errors','on');
error_reporting(E_ALL);
require 'vendor/autoload.php';

const path = "/home/usr/";

session_start();

if (!isset($_GET['url'])){
    $_GET['url'] = '/';
}
$router = new App\Router\Router($_GET['url']);

/****Simple routes*****/
$router->get('/',['flash'], function(){ include(__DIR__."/src/Views/layout.php"); },'Accueil');
/****Simple routes*****/

/****Controllers*****/
$router->get('/posts/:slug-:id',['flash'] ,'Posts.show' ,'posts.show')->with('id', '[0-9]+')->with('slug', '[a-z\-0-9]+');
$router->get('/posts/:id',['flash'] , 'Posts.show', 'Article ');
$router->post('/posts/:id',['flash'] , function($id){ echo 'Poster l\'articles ' . $id; }, 'posts.create');
/****Controllers*****/

/****Files****/
$router->get('/assets/css/:file',[] , 'Files.css', 'Css files')->with('file', '([a-z]+.css)');
$router->get('/assets/js/:file',[] , 'Files.js', 'Js files')->with('file', '([a-z]+.js)');
$router->get('/assets/images/:file',[] , 'Files.png', 'Images files')->with('file', '([a-z\-0-9]+.png)');
$router->get('/assets/images/:file',[] , 'Files.jpg', 'Images files')->with('file', '([a-z\-0-9]+.jpg)');
/****Files****/

$router->run();