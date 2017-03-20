<?php

namespace App\Model;
 
class User {
    private $id,
            $created_at,
            $updated_at,
            $email,
            $encryptedPassword,
            $posts;

    public function __construct(){
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