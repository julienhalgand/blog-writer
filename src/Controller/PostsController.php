<?php
namespace App\Controller;

class PostsController {
    private $loader;
    private $twig;
    private $entries;
    private $PDOManager;
    public function __construct(){
        $this->loader = new \Twig_Loader_Filesystem(path."Views");
        $this->twig =   new \Twig_Environment($this->loader, 
        ['cache' =>  false //'/../tmp' 
        ]);
        $this->PDOManager = new \App\PDOManager();
    }
    public function index(){
       $usersObj = $this->PDOManager->find("user","10");
       var_dump($usersObj);
        echo $this->twig->render('Posts/index.twig', array('title' => 'Tous les posts'));
    }
    public function view(){
        echo $this->twig->render('Posts/view.twig', array('title' => ''));
    }
    public function add(){
        echo $this->twig->render('Posts/add.twig', array('title' => 'Créer un post'));
    }
    public function edit(){
        echo $this->twig->render('Posts/edit.twig', array('title' => ''));
    }
    public function create(){
        $escapedEntries = $this->escape(['title','content']);
        var_dump($dbh);
    }
    public function update($slug, $id){
        
    }
    public function delete($slug, $id){
        
    }
    private function escape(array $keysToEscape){
        $escapedEntries = [];
        foreach ($keysToEscape as $key){
            $escapedEntries[$key] = htmlSpecialChars($_POST[$key]);
        }
        return $escapedEntries;
    }
}