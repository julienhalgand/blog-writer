<?php
namespace App\Controller;

use Respect\Validation\Validator as v;

abstract class ObjectController {
    private $loader;
    private $twig;
    private $manager;
    private $objName;
    private $objNameLowerCase;

    public function __construct($objName){
        $this->loader = new \Twig_Loader_Filesystem(path."Views");
        $this->twig =   new \Twig_Environment($this->loader, 
        ['cache' =>  false, //'/../tmp'
        'debug' => true 
        ]);
        $this->twig->addExtension(new \Twig_Extension_Debug());
        $managerName = "\App\PDOManager\\".$objName."Manager";
        $this->manager = new $managerName();
        $this->objName = $objName;
        $this->objNameLowerCase = strtolower($objName);
    }
    public function index(){
        $this->renderView('/index.twig','Tous les '.$this->objNameLowerCase.'s');
    }
    public function view(){
        $this->renderView('/view.twig','Voir');        
    }
    public function add(){
        $this->renderView('/add.twig','Ajouter un '.$this->objNameLowerCase);        
    }
    public function edit(){
        $this->renderView('/edit.twig','Éditer un '.$this->objNameLowerCase);                
    }
    public function renderView($templateTwig,$title){
        if(isset($_SESSION['auth'])){
            echo $this->twig->render($this->objName.$templateTwig, array('title' => $title, 'success' => $_SESSION['success'], 'error' => $_SESSION['error'], 'user' => $_SESSION['auth']));            
        }else{
            echo $this->twig->render($this->objName.$templateTwig, array('title' => $title, 'success' => $_SESSION['success'], 'error' => $_SESSION['error']));            
        }
        $_SESSION['success'] = "";
        $_SESSION['error'] = "";
    }

    public function getManager(){
        return $this->manager;
    }

    public function isDefine(array $inputs){
        foreach($inputs as $input){           
            if(!isset($_POST[$input])){
               echo ($input." n'est pas définis.");
               break;
            }
        }
    }
}