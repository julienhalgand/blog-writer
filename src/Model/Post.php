<?php

namespace App\Model;
 
class Post {
    private $id;
    private $title;
    private $slug;
    private $content;
    private $commentaries;

    public function __construct(string $title, string $content){
        $this->slug = $slug;
        $this->title = $title;
        $this->content = $content;
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