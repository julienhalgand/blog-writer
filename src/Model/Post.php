<?php
use Respect\Validation\Validator as v;

namespace App\Model;
 
class Post {
    private $id;
    private $title;
    private $slug;
    private $content;
    private $commentaries; //one to many commentary

    public function __construct(string $title, string $content){
        $this->slug = $slug;
        $this->title = $title;
        $this->content = $content;
    }
    public function validate(){
        $postValidator = v::attribute('title', v::stringType()->length(1,50))
                        ->attribute('slug', v::noWhitespace()->stringType()->length(1,50))
                        ->attribute('content', v::stringType()->length(1,65535));
        $postValidator->validate();
    }
    public function getId(){
        return $this->id;
    }
    public function getSlug(){
        return $this->slug;
    }
    public function getTitle(){
        return $this->title;
    }
    public function getTags(){
        return $this->tags;
    }
    public function getContent(){
        return $this->content;
    }

}