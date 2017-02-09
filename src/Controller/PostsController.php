<?php

namespace App\Controller;

$loader = new Twig_Loader_Filesystem("/../Views/Posts");
$twig = new Twig_Environment($loader, [
    'cache' =>  false //'/../tmp' 
]);
 
class PostsController {
    public function index($slug, $id){
        echo $twig->render('index.twig');
    }
    public function view($slug, $id){
        echo $twig->render('view.twig');
    }
    public function add($slug, $id){
        echo $twig->render('add.twig');
    }
    public function edit($slug, $id){
        echo $twig->render('edit.twig');
    }
    public function create($slug, $id){
        
    }
    public function update($slug, $id){
        
    }
    public function delete($slug, $id){
        
    }
}