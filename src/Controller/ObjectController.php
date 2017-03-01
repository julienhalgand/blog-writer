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
        $objects = $this->manager->find("10","1");
        $this->renderView('/index.twig','Tous les '.$this->objNameLowerCase.'s',$objects);       
    }
    public function view(){
        $this->renderView('/view.twig','Voir');
    }
    public function add(){
        $this->renderView('/add.twig','Ajouter un '.$this->objNameLowerCase);
    }
    public function edit($id){
        $object = $this->manager->findOneBy('id',$id,['*']);
        $this->renderView('/edit.twig','Tous les '.$this->objNameLowerCase.'s',$object);        
    }
    public function delete($id){
        $this->manager->delete($id);
    }
    public function renderView($templateTwig,$title,$objects = NULL){
        if($objects === NULL){
            if(isset($_SESSION['auth'])){
                echo $this->twig->render($this->objName.$templateTwig, array('title' => $title, 'success' => $_SESSION['success'], 'error' => $_SESSION['error'], 'user' => $_SESSION['auth']));            
            }else{
                echo $this->twig->render($this->objName.$templateTwig, array('title' => $title, 'success' => $_SESSION['success'], 'error' => $_SESSION['error']));            
            }
        }else{
            if(isset($_SESSION['auth'])){
                echo $this->twig->render($this->objName.$templateTwig, array('title' => $title, 'success' => $_SESSION['success'], 'error' => $_SESSION['error'], 'user' => $_SESSION['auth'], 'objects' => $objects));            
            }else{
                echo $this->twig->render($this->objName.$templateTwig, array('title' => $title, 'success' => $_SESSION['success'], 'error' => $_SESSION['error'], 'objects' => $objects));            
            }
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