<?php

namespace App\Model;
 
class User {
    private $id;
    private $email;
    private $encryptedPassword;
    private $posts; // many to one post

    public function __construct($id,$slug,$title,$tags,$content){
        $this->id = $id;
        $this->slug = $slug;
        $this->title = $title;
        $this->tags = $tags;
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