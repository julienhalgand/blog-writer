<?php
if(!$_SESSION['auth']['isAdmin']){
    $this->loader = new \Twig_Loader_Filesystem(path."Views");
    $this->twig =   new \Twig_Environment($this->loader, 
    ['cache' =>  false //'/../tmp'
    ]);
    http_response_code(404);
    echo $this->twig->render('404.twig', array('title' => "Cette page n'existe pas ou plus !"));
    die;
}