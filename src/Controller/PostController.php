<?php
namespace App\Controller;

use Respect\Validation\Validator as v;

class PostController extends ObjectController{

    public function __construct(){
        parent::__construct("Post");
    }

    public function home($page = NULL){
        $manager = $this->getManager();
        $postNumber = 1;
        $numberOfPosts = $manager->count();
        $pagesTotal = ceil($numberOfPosts/$postNumber);
        if(isset($page)){
            $posts = $manager->find($postNumber,$page);
            $arrayObj['pageActual'] = $page;            
        }else{
            $posts = $manager->find($postNumber,1);
            $arrayObj['pageActual'] = 1;
        }
        if($posts){
            $arrayObj['posts'] = $posts;
            $arrayObj['pagesTotal'] = $pagesTotal;
            $this->renderView('/home.twig','Bienvenue sur le site de Jean Forteroche',$arrayObj);
        }else{
            $this->notFound();
        }
    }

    public function create(){
        $inputs = ['title','content'];
        $this->isDefine($inputs,"/posts");
        if(!v::stringType()->length(1,50)->validate($_POST[$inputs[0]])){
            $this->error("Le format du titre est incorrect.",'/posts');
        }        
        if(!v::stringType()->length(1,65535)->validate($_POST[$inputs[1]])){
            $this->error("Le format du contenus de l'article est incorrect.",'/posts');
        }       
        $arrayObj = [];
        foreach($inputs as $input){
            $arrayObj[$input] = $_POST[$input];
        }        
        $arrayObj['slug'] = $this->slug($arrayObj['title']);
        $manager = $this->getManager();        
        if($manager->findOneBy('slug',$arrayObj['slug'],['slug'])){            
            $this->error("Un post existe a déja été crée avec ce slug.",'/posts');
        }else{
            $manager->create($arrayObj);
            $this->success("Le chapitre a été ajouté avec succès.",'/posts');            
        }
    }
    public function update($id){
        $inputs = ['title','content'];
        $this->isDefine($inputs,"posts");
        if(!v::stringType()->length(1,50)->validate($_POST[$inputs[0]])){
            $this->error("Le format du titre est incorrect.",'/posts');
        }        
        if(!v::stringType()->length(1,65535)->validate($_POST[$inputs[1]])){
            $this->error("Le format du contenus de l'article est incorrect.",'/posts');           
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
        $postManager = $this->getManager();
        $post = $postManager->findOneBy('slug',$slug,['*']);
        if($post){
            $commentariesManager = new \App\PDOManager\CommentaryManager();
            //$commentariesManager->setFetchMode(PDO::FETCH_OBJ);
            $commentariesArray = $commentariesManager->findBy('post_id',$post['id'],['*']);
            $commentariesObjects = [];
            foreach($commentariesArray as $commentary){
                $commentariesObjects[] = new \App\Model\Commentary($commentary);
            }
            var_dump($commentariesObjects);
            /**On trie les commentaires dans l'ordre
            *   -> commentaire niveau 0 .responses
                    -> commentaire niveau 1 .responses
                        -> commentaire niveau 2 .responses
                            -> commentaire niveau 3
            */
            $commentariesLevel0Array = [];
            $commentariesLevel1Array = [];
            $commentariesLevel2Array = [];
            $commentariesLevel3Array = [];
            foreach($commentaries as $commentary){
                switch($commentary['commentary_level']){
                    case 0 :
                        $commentariesLevel0Array[] = $commentary;
                        break;
                    case 1 :
                        $commentariesLevel1Array[] = $commentary;
                        break;
                    case 2 :
                        $commentariesLevel2Array[] = $commentary;
                        break;
                    case 3 :
                        $commentariesLevel3Array[] = $commentary;
                        break;
                }
            }
            //On répartis les commentaires
            $commentariesArray = [];
            foreach($commentariesLevel0Array as $commentaryLevel0){
                foreach($commentariesLevel1Array as $commentaryLevel1){
                    if($commentaryLevel1['commentary_response_id'] == $commentaryLevel0['id']){
                        foreach($commentariesLevel2Array as $commentaryLevel2){
                            if($commentaryLevel2['commentary_response_id'] == $commentaryLevel1['id']){
                                foreach($commentariesLevel3Array as $commentaryLevel3){
                                    if($commentaryLevel3['commentary_response_id'] == $commentaryLevel2['id']){
                                        $commentaryLevel2['responses'][] = $commentaryLevel3;
                                    }
                                }
                                $commentaryLevel1['responses'][] = $commentaryLevel2;
                            }
                        }
                        $commentaryLevel0['responses'][] = $commentaryLevel1;                    
                    }                   
                }
                $commentariesArray[] = $commentaryLevel0;             
                /*var_dump($commentaryLevel0);
                echo("</br>");*/
            }
            //var_dump($commentariesArray);
            $objects['post'] = $post;
            $objects['commentaries'] = $commentariesArray;
            $this->renderView('/see.twig',$post['title'],$objects);
        }else{
            $this->notFound();
        }
    }
    public function delete($id){        
        $manager = $this->getManager();
        $manager->delete($id);
        $this->success("Le chapitre a bien été supprimé.",'/posts');
    }
    private function remove_accent($str){
        $a = array('À', 'Á', 'Â', 'Ã', 'Ä', 'Å', 'Æ', 'Ç', 'È', 'É', 'Ê', 'Ë', 'Ì', 'Í', 'Î', 'Ï', 'Ð',
                        'Ñ', 'Ò', 'Ó', 'Ô', 'Õ', 'Ö', 'Ø', 'Ù', 'Ú', 'Û', 'Ü', 'Ý', 'ß', 'à', 'á', 'â', 'ã',
                        'ä', 'å', 'æ', 'ç', 'è', 'é', 'ê', 'ë', 'ì', 'í', 'î', 'ï', 'ñ', 'ò', 'ó', 'ô', 'õ',
                        'ö', 'ø', 'ù', 'ú', 'û', 'ü', 'ý', 'ÿ', 'Ā', 'ā', 'Ă', 'ă', 'Ą', 'ą', 'Ć', 'ć', 'Ĉ',
                        'ĉ', 'Ċ', 'ċ', 'Č', 'č', 'Ď', 'ď', 'Đ', 'đ', 'Ē', 'ē', 'Ĕ', 'ĕ', 'Ė', 'ė', 'Ę', 'ę',
                        'Ě', 'ě', 'Ĝ', 'ĝ', 'Ğ', 'ğ', 'Ġ', 'ġ', 'Ģ', 'ģ', 'Ĥ', 'ĥ', 'Ħ', 'ħ', 'Ĩ', 'ĩ', 'Ī', 'ī',
                        'Ĭ', 'ĭ', 'Į', 'į', 'İ', 'ı', 'Ĳ', 'ĳ', 'Ĵ', 'ĵ', 'Ķ', 'ķ', 'Ĺ', 'ĺ', 'Ļ', 'ļ', 'Ľ', 'ľ',
                        'Ŀ', 'ŀ', 'Ł', 'ł', 'Ń', 'ń', 'Ņ', 'ņ', 'Ň', 'ň', 'ŉ', 'Ō', 'ō', 'Ŏ', 'ŏ', 'Ő', 'ő', 'Œ',
                        'œ', 'Ŕ', 'ŕ', 'Ŗ', 'ŗ', 'Ř', 'ř', 'Ś', 'ś', 'Ŝ', 'ŝ', 'Ş', 'ş', 'Š', 'š', 'Ţ', 'ţ', 'Ť', 
                        'ť', 'Ŧ', 'ŧ', 'Ũ', 'ũ', 'Ū', 'ū', 'Ŭ', 'ŭ', 'Ů', 'ů', 'Ű', 'ű', 'Ų', 'ų', 'Ŵ', 'ŵ', 'Ŷ', 
                        'ŷ', 'Ÿ', 'Ź', 'ź', 'Ż', 'ż', 'Ž', 'ž', 'ſ', 'ƒ', 'Ơ', 'ơ', 'Ư', 'ư', 'Ǎ', 'ǎ', 'Ǐ', 'ǐ',
                        'Ǒ', 'ǒ', 'Ǔ', 'ǔ', 'Ǖ', 'ǖ', 'Ǘ', 'ǘ', 'Ǚ', 'ǚ', 'Ǜ', 'ǜ', 'Ǻ', 'ǻ', 'Ǽ', 'ǽ', 'Ǿ', 'ǿ');

        $b = array('A', 'A', 'A', 'A', 'A', 'A', 'AE', 'C', 'E', 'E', 'E', 'E', 'I', 'I', 'I', 'I', 'D', 'N', 'O',
                        'O', 'O', 'O', 'O', 'O', 'U', 'U', 'U', 'U', 'Y', 's', 'a', 'a', 'a', 'a', 'a', 'a', 'ae', 'c',
                        'e', 'e', 'e', 'e', 'i', 'i', 'i', 'i', 'n', 'o', 'o', 'o', 'o', 'o', 'o', 'u', 'u', 'u', 'u',
                        'y', 'y', 'A', 'a', 'A', 'a', 'A', 'a', 'C', 'c', 'C', 'c', 'C', 'c', 'C', 'c', 'D', 'd', 'D',
                        'd', 'E', 'e', 'E', 'e', 'E', 'e', 'E', 'e', 'E', 'e', 'G', 'g', 'G', 'g', 'G', 'g', 'G', 'g',
                        'H', 'h', 'H', 'h', 'I', 'i', 'I', 'i', 'I', 'i', 'I', 'i', 'I', 'i', 'IJ', 'ij', 'J', 'j', 'K',
                        'k', 'L', 'l', 'L', 'l', 'L', 'l', 'L', 'l', 'L', 'l', 'N', 'n', 'N', 'n', 'N', 'n', 'n', 'O', 'o',
                        'O', 'o', 'O', 'o', 'OE', 'oe', 'R', 'r', 'R', 'r', 'R', 'r', 'S', 's', 'S', 's', 'S', 's', 'S',
                        's', 'T', 't', 'T', 't', 'T', 't', 'U', 'u', 'U', 'u', 'U', 'u', 'U', 'u', 'U', 'u', 'U', 'u', 'W',
                        'w', 'Y', 'y', 'Y', 'Z', 'z', 'Z', 'z', 'Z', 'z', 's', 'f', 'O', 'o', 'U', 'u', 'A', 'a', 'I', 'i',
                        'O', 'o', 'U', 'u', 'U', 'u', 'U', 'u', 'U', 'u', 'U', 'u', 'A', 'a', 'AE', 'ae', 'O', 'o');
        return str_replace($a, $b, $str);
    }

    private function slug($str){
        return mb_strtolower(preg_replace(array('/[^a-zA-Z0-9 \'-]/', '/[ -\']+/', '/^-|-$/'),
        array('', '-', ''), $this->remove_accent($str)));
    }
}