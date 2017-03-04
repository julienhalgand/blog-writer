<?php

namespace App\Model;
 
class Commentary {
    private $id;
    private $post;
    private $commentary;
    private $reports;
    private $level;
    private $content;

    public function __construct($id,$article,$commentary,$reporting,$content){
        $this->id = $id;
        $this->article = $article;
        $this->commentary = $commentary;
        $this->reports = $reports;
        $this->content = $content;
    }

    public function getId(){
        return $this->id;
    }
    public function getArticle(){
        return $this->article;
    }
    public function getCommentary(){
        return $this->commentary;
    }
    public function getReports(){
        return $this->reports;
    }
    public function getContent(){
        return $this->content;
    }

    public function reporting(){
        $this->reports++;
    }
}