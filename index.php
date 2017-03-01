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
$router = new App\Router\Router($_GET['url']);

$loader = new Twig_Loader_Filesystem($_SERVER['DOCUMENT_ROOT']."/src/Views");
$twig = new Twig_Environment($loader, [
    'cache' =>  false //'/../tmp' 
]);

/****Simple routes*****/
$router->get('/',['flash'],'Post.home' ,'Accueil');
/****Simple routes*****/

/****Controllers*****/
$router->get('/posts',['flash','isAuthenticated','isAdmin'] ,'Post.index' ,'Index posts');
$router->get('/users',['flash','isAuthenticated','isAdmin'] ,'User.index' ,'Index users');
$router->get('/commentaries',['flash','isAuthenticated','isAdmin'] ,'Commentary.index' ,'Index commentaries');
$router->get('/post/add',['flash','isAuthenticated','isAdmin'] ,'Post.add' ,'Add post');
$router->get('/user/signup',['flash'] ,'User.add' ,'Signup');
$router->get('/user/signin',['flash'] ,'User.signin' ,'Signin');
$router->post('/post/create',['flash','isAuthenticated','isAdmin'] ,'Post.create' ,'Create post');
$router->post('/user/create',['flash'] ,'User.create' ,'Create user');
$router->get('/user/profil',['flash'] ,'User.profil' ,'User profil');
$router->post('/session/create',['flash'] ,'User.createSession' ,'Session user');
$router->get('/session/signout',['flash'] ,'User.destroySession' ,'Session user');
$router->get('/post/edit/:id',['flash','isAuthenticated','isAdmin'] ,'Post.edit' ,'Edit post')->with('id', '[0-9]+');
$router->get('/post/:id',['flash'] , 'Post.view', 'Voir post ')->with('id', '[0-9]+');
$router->post('/post/:id',['flash','isAuthenticated','isAdmin'] , 'Post.create' , "Création d'un post")->with('id', '[0-9]+');
$router->post('/post/update/:id',['flash','isAuthenticated','isAdmin'] , 'Post.update' , "Update d'un post")->with('id', '[0-9]+');
$router->post('/post/delete/:id',['flash','isAuthenticated','isAdmin'] , 'Post.delete' , "Delete d'un post")->with('id', '[0-9]+');
/****Controllers*****/

/****Files****/
$router->get('/assets/css/:file',[] , 'File.css', 'Css files')->with('file', '([a-z]+.css)');
$router->get('/assets/js/:file',[] , 'File.js', 'Js files')->with('file', '([a-z]+.js)');
$router->get('/assets/js/vendor/:file',[] , 'File.jsVendor', 'Js vendor files')->with('file', '([a-z]+.js)');
$router->get('/assets/images/:file',[] , 'File.png', 'Images files')->with('file', '([a-z\-0-9]+.png)');
$router->get('/assets/images/:file',[] , 'File.jpg', 'Images files')->with('file', '([a-z\-0-9]+.jpg)');
/****Files****/

$router->run();