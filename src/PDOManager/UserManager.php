<?php
namespace App\PDOManager;

class UserManager extends PDOManager{

    private $loader;
    private $twig;
    
    public function __construct(){
        $this->loader = new \Twig_Loader_Filesystem(path."Views");
        $this->twig =   new \Twig_Environment($this->loader, 
        ['cache' =>  false //'/../tmp' 
        ]);
    }
    public function signup(){
        echo $this->twig->render('User/signup.twig', array('title' => 'Créer un compte'));
    }
    public function createUser($arrayObj){

        //Encrypt password
        $this->create($arrayObj);
    }

}