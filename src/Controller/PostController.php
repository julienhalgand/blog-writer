<?php
namespace App\Controller;

use Respect\Validation\Validator as v;

class PostController extends ObjectController{

    public function __construct(){
        parent::__construct("Post");
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

        $manager = $this->getManager();
        $manager->createPost($arrayObj);
    }
    public function update($slug, $id){
        
    }
    public function delete($id){
        
    }
}