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
    public function signup(){
        $this->renderView('/signup.twig','Inscription');
    }
    public function profil(){
        $this->renderView('/profil.twig','Profil');
    }
    public function createSession(){
        //Tests
        $inputs = ['email','password'];
        $this->isDefine($inputs,"/user/signin");
        if(!v::email()->length(1,100)->validate($_POST[$inputs[0]])){
            $this->error("Le format de l'email est incorrect.",'/user/signin');
        }
        if(!v::stringType()->length(1,50)->validate($_POST[$inputs[1]])){
            $this->error("Le format du mot de passe est incorrect.",'/user/signin');
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
                $this->success("Bienvenue.",'/');
            }else{
                $this->error("Email ou mot de passe invalide.",'/user/signin');
            }
        }else{
            $this->error("Email ou mot de passe invalide.",'/user/signin');
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
        $this->isDefine($inputs,"/user/signup");
        if(!v::email()->length(1,100)->validate($_POST[$inputs[0]])){
            $this->error("Le format de l'email est incorrect.",'/user/signup');
        }        
        if(!v::stringType()->length(1,50)->validate($_POST[$inputs[1]])){
            $this->error("Le format du mot de passe est incorrect.",'/user/signup');         
        }
        if(!v::stringType()->length(1,50)->validate($_POST[$inputs[2]])){
            $this->error("Le format de la confirmation du mot de passe est incorrect.",'/user/signup');           
        }          
        $arrayObj = [];
        if($_POST['password'] === $_POST['confirmationPassword']){
            $arrayObj['encrypted_password'] = password_hash($_POST['password'], PASSWORD_BCRYPT);
        }else{
            $this->error("Les mots de passes ne correspondent pas.",'/user/signup');
        }
        $arrayObj['email'] = $_POST['email'];
        $manager = $this->getManager();       
        if($manager->findOneBy('email',$arrayObj['email'],['email'])){            
            $this->error("Un compte existe déja avec cette adresse email.",'/user/signup');
        }else{
            $manager->create($arrayObj);
            $this->success("Merci de vous être inscrit sur notre site, vous pouvez maintenant vous connecter à l'aide du formulaire ci-dessous.",'/user/signin');            
        }
    }
    public function update($slug, $id){
        
    }
    public function delete($id){        
        $manager = $this->getManager();
        $manager->delete($id);
        $this->success("Merci de vous être inscrit sur notre site, vous pouvez maintenant vous connecter à l'aide du formulaire ci-dessous.",'/users');        
    }
}