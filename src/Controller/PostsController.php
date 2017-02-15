<?php
namespace App\Controller;

class PostsController {
    private $loader;
    private $twig;

    public function __construct(){
        $this->loader = new \Twig_Loader_Filesystem(path."Views");
        $this->twig =   new \Twig_Environment($this->loader, 
        ['cache' =>  false //'/../tmp' 
        ]);
    }
    public function index(){
        print("uitsc'itsu");
        echo $this->twig->render('Posts/index.twig');
    }
    public function view(){
        echo $this->twig->render('Posts/view.twig');
    }
    public function add(){
        echo $this->twig->render('Posts/add.twig');
    }
    public function edit(){
        echo $this->twig->render('Posts/edit.twig');
    }
    public function create($slug, $id){
        
    }
    public function update($slug, $id){
        
    }
    public function delete($slug, $id){
        
    }
}