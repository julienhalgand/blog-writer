<?php
if(!array_key_exists('auth',$_SESSION)){
    $this->loader = new \Twig_Loader_Filesystem(path."Views");
    $this->twig =   new \Twig_Environment($this->loader, 
    ['cache' =>  false //'/../tmp'
    ]);
    function error(string $message, string $url){
        $_SESSION['error'] = $message;
        header("Location: ".$url);
        die; 
    }
    error("Vous devez être connecté pour utiliser cette fonctionnalité.",'/user/signin');
}