<?php
namespace App\Controller;

use Respect\Validation\Validator as v;

class UserController extends ObjectController {

    public function __construct(){
        parent::__construct("User");
    }
    public function signin(){
        $this->renderView('/signin.twig','Connexion');
    }
    public function profil(){
        $this->renderView('/profil.twig','Profil');
    }
    public function createSession(){
        //Tests
        $inputs = ['email','password'];
        $this->isDefine($inputs);
        if(!v::email()->length(1,100)->validate($_POST[$inputs[0]])){
            $_SESSION['error'] = "Le format de l'email est incorrect.";
        }        
        if(!v::stringType()->length(1,50)->validate($_POST[$inputs[1]])){
            $_SESSION['error'] = "Le format du mot de passe est incorrect.";         
        }
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
                $_SESSION['auth'] = $user;
                $_SESSION['success'] = "Bienvenue.";
                header('Location: /user/profil'); 
            }else{
                $_SESSION['error'] = "Email ou mot de passe invalide.";
                header('Location: /user/signin'); 
            }           
        }else{
            $_SESSION['error'] = "Email ou mot de passe invalide.";
            header('Location: /user/signin'); 
        }
    }
    public function destroySession(){
        session_destroy();
        session_start();
        $_SESSION['success'] = "À bientôt !";
        $_SESSION['error'] = "";
        header('Location: /'); 
    }
    public function create(){
        $inputs = ['email','password','confirmationPassword'];
        $this->isDefine($inputs);
        if(!v::email()->length(1,100)->validate($_POST[$inputs[0]])){
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
        $_SESSION['success'] = "Merci de vous être inscrit sur notre site, vous pouvez maintenant vous connecter à l'aide du formulaire ci-dessous.";
        header('Location: /user/signin'); 
    }
    public function update($slug, $id){
        
    }
    public function delete($id){        
        $manager = $this->getManager();
        $manager->delete($id);
        $_SESSION['success'] = "Le chapitre a bien été supprimé.";
        header('Location: /posts'); 
    }
}