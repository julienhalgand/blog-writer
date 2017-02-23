<?php
namespace App\Controller;

class SessionController {
    private $loader;
    private $twig;
    
    public function __construct(){
        $this->loader = new \Twig_Loader_Filesystem(path."Views");
        $this->twig =   new \Twig_Environment($this->loader, 
        ['cache' =>  false //'/../tmp' 
        ]);
    }
    public function signin(){
        
    }
    public function create($slug, $id){
        
    }
    public function delete($slug, $id){
        
    }
}