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
    public function index($page = NULL){
        $objectNumber = 10;
        $numberOfObjects = $this->manager->count();
        $pagesTotal = ceil($numberOfObjects/$objectNumber);
        if(isset($page)){
            $objects = $this->manager->find($objectNumber,$page);
            $arrayObj['pageActual'] = $page;            
        }else{
            $objects = $this->manager->find($objectNumber,1);
            $arrayObj['pageActual'] = 1;
        }
        if($objects){
            $arrayObj['objects'] = $objects;
            $arrayObj['pagesTotal'] = $pagesTotal;
            $this->renderView('/index.twig','Tous les '.$this->objNameLowerCase.'s',$arrayObj);
        }
              
    }
    public function see($id){
        $object = $this->manager->findOneBy('id',$id,['*']);
        $this->renderView('/see.twig','Voir un '.$this->objNameLowerCase,$object); 
    }
    public function add(){
        $this->renderView('/add.twig','Ajouter un '.$this->objNameLowerCase);
    }
    public function edit($id){
        $object = $this->manager->findOneBy('id',$id,['*']);
        $this->renderView('/edit.twig','Tous les '.$this->objNameLowerCase.'s',$object);        
    }
    /**
    *public function delete($id,$url,$message){
    *    $this->manager->delete($id);
    *    $this->error($message,$url);        
    *}
    */
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
    public function notFound(){
        http_response_code(404);
        echo $this->twig->render('404.twig', array('title' => "Cette page n'existe pas ou plus !", 'success' => $_SESSION['success'], 'error' => $_SESSION['error'], 'user' => $_SESSION['auth']));
        die;
    }
    public function getManager(){
        return $this->manager;
    }

    public function isDefine(array $inputs, string $url){
        foreach($inputs as $input){           
            if(!isset($_POST[$input])){
                $this->error($input." n'est pas définis.",$url);
            }
        }
    }
    public function error(string $message, string $url){
        $_SESSION['error'] = $message;
        header("Location: ".$url);
        die; 
    }
    public function success(string $message, string $url){
        $_SESSION['success'] = $message;
        header("Location: ".$url);
        die; 
    }
}