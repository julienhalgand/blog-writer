<?php


namespace App\Controller;
use Respect\Validation\Validator as v;
class PostsController {
    private $loader;
    private $twig;
    private $entries;
    private $PostsManager;
    public function __construct(){
        $this->loader = new \Twig_Loader_Filesystem(path."Views");
        $this->twig =   new \Twig_Environment($this->loader, 
        ['cache' =>  false //'/../tmp' 
        ]);
        $this->PostsManager = new \App\PDOManager\PostsManager();
    }
    public function index(){
       $usersObj = $this->PDOManager->find("user","10");
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
        $inputs = ['title','content'];
        $this->isDefine($inputs);
        if(!v::stringType()->length(1,50)->validate($_POST[$inputs[0]])){
            echo("Le format du titre est incorrect.");
        }        
        if(!v::stringType()->length(1,65535)->validate($_POST[$inputs[1]])){
            echo("Le format du contenus de l'article est incorrect.");            
        }       
        $arrayObj = [];
        foreach($inputs as $input){
            $arrayObj[$input] = $_POST[$input];
        }
        $this->PostsManager->createPost($arrayObj);
    }
    public function update($slug, $id){
        
    }
    public function delete($slug, $id){
        
    }
    private function isDefine(array $inputs){
        foreach($inputs as $input){           
            if(!isset($_POST[$input])){
               echo ($input." n'est pas définis.");
               break;
            }
        }
    }
}