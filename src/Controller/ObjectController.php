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
        ['cache' =>  false //'/../tmp' 
        ]);
        $managerName = "\App\PDOManager\\".$objName."Manager";
        $this->manager = new $managerName();
        $this->objName = $objName;
        $this->objNameLowerCase = strtolower($objName);
    }
    public function index(){
        echo $this->twig->render($this->objName.'/index.twig', array('title' => 'Tous les '.$this->objNameLowerCase.'s'));
    }
    public function view(){
        echo $this->twig->render($this->objName.'/view.twig', array('title' => ''));
    }
    public function add(){
        echo $this->twig->render($this->objName.'/add.twig', array('title' => 'Créer un '.$this->objNameLowerCase));
    }
    public function edit(){
        echo $this->twig->render($this->objName.'/edit.twig', array('title' => 'Éditer un '.$this->objNameLowerCase));
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