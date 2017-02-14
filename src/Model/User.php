<?php

namespace App\Model;
 
class User {
    private $id;
    private $email;
    private $encryptedPassword;
    private $posts; // many to one post

    public function __construct($id,$email,$title,$tags,$content){
        $this->id = $id;
        $this->email = $email;
        $this->title = $title;
        $this->tags = $tags;
        $this->content = $content;
    }

    public function getId(){
        return $this->id;
    }
    public function getEmail(){
        return $this->email;
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