<?php
namespace App\Controller;

use Respect\Validation\Validator as v;

class CommentaryController extends ObjectController{

    public function __construct(){
        parent::__construct("Commentary");
    }

    public function create(){
        $inputs = ['content','post_id'];
        $this->isDefine($inputs);
        $arrayObj = [];
        foreach($inputs as $input){
            $arrayObj[$input] = $_POST[$input];
        }
        $postManager = new \App\PDOManager\PostManager();
        $slug = $postManager->findOneBy('id',$arrayObj['post_id'],['slug'])['slug'];
        if(isset($slug)){
            if(!v::stringType()->length(1,50)->validate($_POST[$inputs[0]])){
                $_SESSION['error'] = "Le format du contenus est incorrect.";
                header('Location: /post/see/'.$slug); 
            }
            if(!v::numeric()->validate($_POST[$inputs[1]])){
                $_SESSION['error'] = "Le format de l'id est incorrect.";
                header('Location: /post/see/'.$slug);
                die;
            }
            /**
            *Si l'utilisateur est connecté
            */
            if(isset($_SESSION['auth'])){
                /**
                *Si il s'agit d'une réponse a un commentaire
                */
                //On initialise le commentaryManager
                $commentaryManager = $this->getManager();
                if(isset($_POST['commentary_id'])){
                    //Id du commentaire auxquel il répond
                    $arrayObj['commentary_response_id'] = $_POST['commentary_id'];
                    //On récupère le commentaire pour connaître son commentary_level
                    $commentaryLevel = $commentaryManager->findOneBy('id',$arrayObj['commentary_response_id'],['commentary_level'])['commentary_level'];
                    //var_dump($commentaryLevel);
                    //On test si commentary_level ne dépasse pas 3
                    if($commentaryLevel < 3){
                        $arrayObj['commentary_level'] = $commentaryLevel+1;
                    }else{
                        $_SESSION['error'] = "Seulement 3 niveaux de commentaires sont autorisés.";
                        header('Location: /post/see/'.$slug);
                        die;
                    }                    
                }
                //Id de l'auteur du commentaire
                $arrayObj['user_id'] = $_SESSION['auth']['id'];
                //Création du commentaire
                $commentaryManager->create($arrayObj);
                $_SESSION['success'] = "Votre commentaire a été ajouté avec succès.";
                header('Location: /post/see/'.$slug);
            /**
            *Si l'utilisateur n'est pas connecté
            */
            }else{
                $_SESSION['error'] = "Vous devez être connecté pour vous connecter.";
                header('Location: /post/see/'.$slug); 
            }
        }else{
            $this->notFound();
        }
        

    }
    public function update($id){
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
        $manager->update($id,$arrayObj);
        $_SESSION['success'] = "Le chapitre a bien été mis à jour.";
        header('Location: /posts'); 
    }
    public function see($slug){
        $manager = $this->getManager();
        $object = $manager->findOneBy('slug',$slug,['*']);
        $this->renderView('/see.twig',$object['title'],$object); 
    }
    public function delete($id){        
        $manager = $this->getManager();
        $manager->delete($id);
        $_SESSION['success'] = "Le chapitre a bien été supprimé.";
        header('Location: /posts'); 
    }

}