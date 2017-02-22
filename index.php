<?php
declare(strict_types=1);
/**/
ini_set('display_errors','on');
error_reporting(E_ALL);
//phpinfo();
//*/
const path = "/Users/JulienHalgand/Documents/Projets/Projet3/blog/src/";
require 'vendor/autoload.php';


if (!array_key_exists('url',$_GET)){
    $_GET['url'] = '/';
}
var_dump( $_SERVER['DOCUMENT_ROOT'] );
$router = new App\Router\Router($_GET['url']);

$loader = new Twig_Loader_Filesystem(path."Views");
$twig = new Twig_Environment($loader, [
    'cache' =>  false //'/../tmp' 
]);

/****Simple routes*****/
$router->get('/',['flash'], function(){ global $twig; echo $twig->render('home.twig', array('title' => 'Bienvenue sur le blog de Jean Forteroche')); },'Accueil');
/****Simple routes*****/

/****Controllers*****/
$router->get('/posts',['flash','isAuthenticated','isAdmin'] ,'Posts.index' ,'Index posts');
$router->get('/post/add',['flash','isAuthenticated','isAdmin'] ,'Posts.add' ,'Add post');
$router->post('/post/create',['flash','isAuthenticated','isAdmin'] ,'Posts.create' ,'Create post');
$router->get('/post/edit/:id',['flash','isAuthenticated','isAdmin'] ,'Posts.edit' ,'Edit post')->with('id', '[0-9]+');
$router->get('/post/:id',['flash'] , 'Posts.view', 'Voir post ')->with('id', '[0-9]+');
$router->post('/post/:id',['flash','isAuthenticated','isAdmin'] , 'Posts.create' , "Création d'un post")->with('id', '[0-9]+');
$router->put('/post/:id',['flash','isAuthenticated','isAdmin'] , 'Posts.update' , "Update d'un post")->with('id', '[0-9]+');
$router->delete('/post/:id',['flash','isAuthenticated','isAdmin'] , 'Posts.delete' , "Delete d'un post")->with('id', '[0-9]+');
/****Controllers*****/

/****Files****/
$router->get('/assets/css/:file',[] , 'Files.css', 'Css files')->with('file', '([a-z]+.css)');
$router->get('/assets/js/:file',[] , 'Files.js', 'Js files')->with('file', '([a-z]+.js)');
$router->get('/assets/js/vendor/:file',[] , 'Files.jsVendor', 'Js vendor files')->with('file', '([a-z]+.js)');
$router->get('/assets/images/:file',[] , 'Files.png', 'Images files')->with('file', '([a-z\-0-9]+.png)');
$router->get('/assets/images/:file',[] , 'Files.jpg', 'Images files')->with('file', '([a-z\-0-9]+.jpg)');
/****Files****/

$router->run();