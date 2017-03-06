<?php
namespace App\Controller;

use Respect\Validation\Validator as v;

class CommentaryController extends ObjectController{

    public function __construct(){
        parent::__construct("Commentary");
    }

    public function create(){
        $inputs = ['content','post_id'];
        $postManager = new \App\PDOManager\PostManager();
        $slug = $postManager->findOneBy('id',$_POST['post_id'],['slug'])['slug'];
        if(isset($slug)){
            $this->isDefine($inputs,"/post/see/".$slug);
            $arrayObj = [];
            foreach($inputs as $input){
                $arrayObj[$input] = $_POST[$input];
            }
            if(!v::stringType()->length(1,50)->validate($_POST[$inputs[0]])){
                $this->error("Le format du contenus est incorrect.",'Location: /post/see/'.$slug);
            }
            if(!v::numeric()->validate($_POST[$inputs[1]])){
                $this->error("Le format de l'id est incorrect.",'Location: /post/see/'.$slug);
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
                        $this->error("Seulement 3 niveaux de commentaires sont autorisés.",'Location: /post/see/'.$slug);
                    }                    
                }
                //Id de l'auteur du commentaire
                $arrayObj['user_id'] = $_SESSION['auth']['id'];
                //Création du commentaire
                $commentaryManager->create($arrayObj);
                $this->success("Votre commentaire a été ajouté avec succès.",'Location: /post/see/'.$slug);
            /**
            *Si l'utilisateur n'est pas connecté
            */
            }else{
                $this->error("Vous devez être connecté pour crée un commentaire.",'Location: /post/see/'.$slug);
            }
        }else{
            $this->notFound();
        }
        

    }
    public function update($id){
        $inputs = ['title','content'];
        $this->isDefine($inputs,"/commentaries");
        if(!v::stringType()->length(1,50)->validate($_POST[$inputs[0]])){
            $this->error("Le format du titre est incorrect.",'Location: /posts');
        }        
        if(!v::stringType()->length(1,65535)->validate($_POST[$inputs[1]])){
            $this->error("Le format du contenus de l'article est incorrect.",'Location: /posts');       
        }       
        $arrayObj = [];
        foreach($inputs as $input){
            $arrayObj[$input] = $_POST[$input];
        }
        
        $manager = $this->getManager();
        $manager->update($id,$arrayObj);
        $this->success("Le chapitre a bien été mis à jour.",'Location: /posts');
    }
    public function see($slug){
        $manager = $this->getManager();
        $object = $manager->findOneBy('slug',$slug,['*']);
        $this->renderView('/see.twig',$object['title'],$object); 
    }
    public function delete($id){        
        $manager = $this->getManager();
        $manager->delete($id);
        $this->success("Le commentaire a bien été supprimé.",'Location: /posts');
    }

}