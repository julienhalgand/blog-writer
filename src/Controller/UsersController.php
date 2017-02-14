<?php
namespace App\Controller;

class UsersController {
    private $loader;
    private $twig;

    public function __construct(){
        $this->loader = new \Twig_Loader_Filesystem(path."Views/Users");
        $this->twig =   new \Twig_Environment($this->loader, 
        ['cache' =>  false //'/../tmp' 
        ]);
    }
    public function index(){
        echo $this->twig->render('index.twig');
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