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

/****Controllers*****/
$router->get('/',['flash'],'Post.home' ,'Accueil');
$router->get('/posts',['flash','isAuthenticated','isAdmin'] ,'Post.index' ,'Index posts');
$router->get('/users',['flash','isAuthenticated','isAdmin'] ,'User.index' ,'Index users');
$router->get('/commentaries',['flash','isAuthenticated','isAdmin'] ,'Commentary.index' ,'Index commentaries');
$router->get('/post/add',['flash','isAuthenticated','isAdmin'] ,'Post.add' ,'Add post');
$router->get('/user/signup',['flash'] ,'User.signup' ,'Signup');
$router->get('/user/signin',['flash'] ,'User.signin' ,'Signin');
$router->post('/post/create',['flash','isAuthenticated','isAdmin'] ,'Post.create' ,'Create post');
$router->post('/user/create',['flash'] ,'User.create' ,'Create user');
$router->post('/commentary/create',['flash'] ,'Commentary.create' ,'Create commentary');
$router->post('/report/create',['flash'] ,'Report.create' ,'Create report');
$router->get('/page/:page',['flash'],'Post.home' ,'Accueil page')->with('page', '[0-9]+');
$router->post('/session/create',['flash'] ,'User.createSession' ,'Session user');
$router->get('/session/signout',['flash'] ,'User.destroySession' ,'Session user');
$router->get('/post/edit/:id',['flash','isAuthenticated','isAdmin'] ,'Post.edit' ,'Edit post')->with('id', '[0-9]+');
$router->get('/commentary/edit/:id',['flash','isAuthenticated','isAdmin'] ,'Commentary.edit' ,'Edit commentary')->with('id', '[0-9]+');
$router->get('/post/see/:slug',['flash'] ,'Post.see' ,'See post')->with('slug', '[a-z0-9](-?[a-z0-9]+)*');
$router->post('/post/:id',['flash','isAuthenticated','isAdmin'] , 'Post.create' , "Création d'un post")->with('id', '[0-9]+');
$router->get('/posts/:id',['flash','isAuthenticated','isAdmin'] , 'Post.index' , "Index posts page")->with('id', '[0-9]+');
$router->get('/commentaries/:id',['flash','isAuthenticated','isAdmin'] , 'Commentary.index' , "Index commentaries page")->with('id', '[0-9]+');
$router->get('/users/:id',['flash','isAuthenticated','isAdmin'] , 'User.index' , "Index users page")->with('id', '[0-9]+');
$router->post('/post/update/:id',['flash','isAuthenticated','isAdmin'] , 'Post.update' , "Update d'un post")->with('id', '[0-9]+');
$router->post('/commentary/update/:id',['flash','isAuthenticated','isAdmin'] , 'Commentary.update' , "Update d'un commentaire")->with('id', '[0-9]+');
$router->post('/post/delete/:id',['flash','isAuthenticated','isAdmin'] , 'Post.delete' , "Delete d'un post")->with('id', '[0-9]+');
$router->post('/commentary/delete/:id',['flash','isAuthenticated','isAdmin'] , 'Commentary.delete' , "Delete d'un commentary")->with('id', '[0-9]+');
$router->post('/user/delete/:id',['flash','isAuthenticated','isAdmin'] , 'User.delete' , "Delete d'un user")->with('id', '[0-9]+');
/****Controllers*****/

/****Files****/
$router->get('/assets/css/:file',[] , 'File.css', 'Css files')->with('file', '([a-z]+.css)');
$router->get('/assets/js/:file',[] , 'File.js', 'Js files')->with('file', '([a-z]+.js)');
$router->get('/assets/js/vendor/:file',[] , 'File.jsVendor', 'Js vendor files')->with('file', '([a-z]+.js)');
$router->get('/assets/images/:file',[] , 'File.png', 'Images files')->with('file', '([a-z\-0-9]+.png)');
$router->get('/assets/images/:file',[] , 'File.jpg', 'Images files')->with('file', '([a-z\-0-9]+.jpg)');
/****Files****/

$router->run();