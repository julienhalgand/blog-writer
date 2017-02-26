<?php
namespace App\Controller;

use Respect\Validation\Validator as v;

class SessionController extends ObjectController{

    public function __construct(){
        parent::__construct("User");
    }

    public function create(){
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
    public function delete(){
        
    }
}