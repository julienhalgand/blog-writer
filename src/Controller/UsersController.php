<?php
namespace App\Controller;

class UsersController {
    private $loader;
    private $twig;

    public function __construct(){
        $this->loader = new \Twig_Loader_Filesystem(path."Views");
        $this->twig =   new \Twig_Environment($this->loader, 
        ['cache' =>  false //'/../tmp' 
        ]);
    }
    public function index(){
        echo $this->twig->render('Users/index.twig');
    }
    public function profil($slug, $id){
        echo $twig->render('Users/profil.twig');
    }
    public function signup($slug, $id){
        echo $twig->render('Users/signup.twig');
    }
    public function signin($slug, $id){
        echo $twig->render('Users/signin.twig');
    }
    public function create($slug, $id){
        
    }
    public function update($slug, $id){
        
    }
    public function delete($slug, $id){
        
    }
}