<?php

namespace App\Model;
 
class Post {
    private $id,
            $created_at,
            $updated_at,
            $title,
            $slug,
            $summary,
            $content,
            $commentaries;

    public function __construct(){
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