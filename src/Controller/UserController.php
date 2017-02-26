<?php
namespace App\Controller;

use Respect\Validation\Validator as v;

class UserController extends ObjectController {

    public function __construct(){
        parent::__construct("User");
    }
    public function signin(){
        echo $this->getTwig()->render($this->getObjName().'/signin.twig', array('title' => 'Connexion'));
    }
    public function createSession(){
        //Tests 
        $fieldSearched = 'email';
        $manager = $this->getManager();
        $user = $manager->findOneBy($fieldSearched,$_POST[$fieldSearched],['id','email','encrypted_password','is_admin']);
        //Test mot de passe
        if($user){
            if(password_verify($_POST['password'], $user['encrypted_password'])){
                //Création de la variable session
                $user = array(
                    'id' => $user['id'],
                    'email' => $user['email'],
                    'isAdmin' => $user['is_admin']
                );
                $_SESSION['auth'] = array($user);
                var_dump($_SESSION['auth']);
            }else{

            }
            
        }
    }
    
    public function create(){
        $inputs = ['email','password','confirmationPassword'];
        $this->isDefine($inputs);
        if(!v::stringType()->length(1,100)->validate($_POST[$inputs[0]])){
            echo("Le format de l'email est incorrect.");
        }        
        if(!v::stringType()->length(1,50)->validate($_POST[$inputs[1]])){
            echo("Le format du mot de passe est incorrect.");            
        }
        if(!v::stringType()->length(1,50)->validate($_POST[$inputs[2]])){
            echo("Le format de la confirmation du mot de passe est incorrect.");            
        }          
        $arrayObj = [];
        if($_POST['password'] === $_POST['confirmationPassword']){
            $arrayObj['encrypted_password'] = password_hash($_POST['password'], PASSWORD_BCRYPT);
        }else{
            echo("Les mots de passes ne correspondent pas.");                        
        }
        $arrayObj['email'] = $_POST['email'];
        $manager = $this->getManager();
        $manager->create($arrayObj);
    }
    public function update($slug, $id){
        
    }
    public function delete($slug, $id){
        
    }
}