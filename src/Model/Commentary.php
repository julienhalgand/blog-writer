<?php

namespace App\Model;
 
class Commentary {
    private $id;
    private $post;
    private $commentary;
    private $reports;
    private $level;
    private $content;

    public function __construct(array $objectArray){
        $this->hydrate($objectArray);
    }
    public function hydrate(array $objectArray){
        foreach ($objectArray as $key => $value){
            // On récupère le nom du setter correspondant à l'attribut.
            $method = 'set'.ucfirst($key);
                
            // Si le setter correspondant existe.
            if (method_exists($this, $method)){
                // On appelle le setter.
                $this->$method($value);
            }
        }
    }
    /*GETTERS*/
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
    /*GETTERS*/
    /*SETTERS*/
    public function setId($id){
        return $this->content;
    }
    /*SETTERS*/
    
}