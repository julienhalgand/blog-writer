<?php
namespace App\Controller;

use Respect\Validation\Validator as v;

class PostController extends ObjectController{

    public function __construct(){
        parent::__construct("Post");
    }
    public function index($page = NULL){
        $objectNumber = 10;
        $numberOfObjects = $this->manager->count();
        $pagesTotal = ceil($numberOfObjects/$objectNumber);
        if(isset($page)){
            $objects = $this->manager->findDesc($objectNumber,$page);
            $arrayObj['pageActual'] = $page;            
        }else{
            $objects = $this->manager->findDesc($objectNumber,1);
            $arrayObj['pageActual'] = 1;
        }
        $arrayObj['objects'] = $objects;
        $arrayObj['pagesTotal'] = $pagesTotal;
        $this->renderView('/index.twig','Tous les posts',$arrayObj);            
    }
    public function home($page = NULL){
        $manager = $this->getManager();
        $postNumber = 10;
        $numberOfPosts = $manager->count();
        $pagesTotal = ceil($numberOfPosts/$postNumber);
        if(isset($page)){
            $posts = $manager->findDesc($postNumber,$page);
            $arrayObj['pageActual'] = $page;            
        }else{
            $posts = $manager->findDesc($postNumber,1);
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
        $inputs = ['title','summary','content'];
        $this->isDefine($inputs,"/posts");
        if(!v::stringType()->length(1,255)->validate($_POST[$inputs[0]])){
            $this->error("Le format du titre est incorrect.",'/posts');
        }
        if(!v::stringType()->length(1,255)->validate($_POST[$inputs[1]])){
            $this->error("Le format du résumé est incorrect.",'/posts');
        }
        if(!v::stringType()->length(1,pow(2,32)-1)->validate($_POST[$inputs[2]])){
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
        $inputs = ['title','summary','content'];
        $this->isDefine($inputs,"/posts");
        if(!v::stringType()->length(1,255)->validate($_POST[$inputs[0]])){
            $this->error("Le format du titre est incorrect.",'/posts');
        }
        if(!v::stringType()->length(1,255)->validate($_POST[$inputs[1]])){
            $this->error("Le format du résumé est incorrect.",'/posts');
        }
        if(!v::stringType()->length(1,pow(2,32)-1)->validate($_POST[$inputs[2]])){
            $this->error("Le format du contenus de l'article est incorrect.",'/posts');           
        }         
        $arrayObj = [];
        foreach($inputs as $input){
            $arrayObj[$input] = $_POST[$input];
        }
        $arrayObj['slug'] = $this->slug($arrayObj['title']);
        $manager = $this->getManager();
        $manager->update($id,$arrayObj);
        $this->success("Le chapitre a bien été mis à jour.",'/posts');
    }
    public function see($slug){
        $postManager = $this->getManager();
        $post = $postManager->findOneBy('slug',$slug,['*']);
        if($post){
            $commentariesManager = new \App\PDOManager\CommentaryManager();
            //$commentariesManager = $commentariesManager->getPDO();
            /**$commentariesObjects = $commentariesManager->findObjectByGroupBy('post_id',$post['id'],['*'],'commentary_response_id');
            /**/$commentariesObjects = $commentariesManager->findObjectByOrderBy('post_id',$post['id'],['*'],'commentary_level');
            /**$commentariesObjects = $commentariesManager->getPDO()->query("SELECT * FROM commentary LEFT JOIN commentary AS response ON response.commentary_response_id = commentary.id WHERE commentary.post_id = ".$post['id'])            
            ->fetchAll(\PDO::FETCH_CLASS, "\\App\\Model\\Commentary");
            //*/
            /*
            echo("<pre>");
            var_dump($commentariesObjects);
            echo("</pre>");
            //*/
            $commentaries = [];
            foreach($commentariesObjects as $commentary){
                if($commentary->getCommentary_level() === 0){
                    $commentaries[] = $commentary;
                }else{
                    $this->getMyChild($commentaries, $commentary);
                }
            }
            $objects['post'] = $post;
            $objects['commentaries'] = $commentaries;
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

    private function getMyChild($commentaries,$commentary){
        foreach($commentaries as $parent){
            //Test si niveau commentaire est correct
            if($parent->getCommentary_level() === $commentary->getCommentary_level()-1){
                if($parent->isMyChild($commentary)){ $parent->addChild($commentary);}
            }else{  
                $this->getMyChild($parent->getChilds(),$commentary);
            }                     
        }
    }
}