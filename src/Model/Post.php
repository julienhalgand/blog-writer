<?php

namespace App\Model;
 
class Post {
    private $id;
    private $slug;
    private $title;
    private $tags;
    private $content;
    private $commentaries; //one to many commentary

    public function __construct($id,$slug,$title,$tags,$content){
        $this->id = $id;
        $this->slug = $slug;
        $this->title = $title;
        $this->tags = $id;
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