<?php

namespace App\Model;
 
class Commentary {
    private $id,
            $created_at,
            $updated_at,
            $commentary_level,
            $content,
            $number_of_reports,
            $user_id,
            $post_id,
            $commentary_response_id,
            $childs = [];

    public function __construct(){
    }
    /*GETTERS*/
    public function getId(){
        return $this->id;
    }
    public function getCreated_at(){
        return $this->created_at;
    }
    public function getUpdated_at(){
        return $this->updated_at;
    }
    public function getCommentary_level(){
        return $this->commentary_level;
    }
    public function getContent(){
        return $this->content;
    }
    public function getNumber_of_reports(){
        return $this->number_of_reports;
    }
    public function getUser_id(){
        return $this->user_id;
    }
    public function getPost_id(){
        return $this->post_id;
    }
    public function getCommentary_response_id(){
        return $this->commentary_response_id;            
    }
    /*GETTERS*/
    /*SETTERS*/
    public function setId($id){
        return $this->id = $id;
    }
    public function setCreated_at($created_at){
        return $this->created_at = $created_at;
    }
    public function setUpdated_at($updated_at){
        return $this->updated_at = $updated_at;
    }
    public function setCommentary_level($commentary_level){
        return $this->commentary_level = $commentary_level;
    }
    public function setContent($content){
        return $this->content = $content;
    }
    public function setNumber_of_reports($number_of_reports){
        return $this->number_of_reports = $number_of_reports;
    }
    public function setUser_id($user_id){
        return $this->user_id = $user_id;
    }
    public function setPost_id($post_id){
        return $this->post_id = $post_id;
    }
    public function setCommentary_response_id($commentary_response_id){
        if(isset($commentary_response_id)){
            return $this->commentary_response_id = $commentary_response_id;            
        }
    }
    /*SETTERS*/
    /*ClASS FUNCTIONS*/
    public function addChild(Commentary $comment){
        $this->childs[] = $comment;
    }
    public function isMyChild(Commentary $comment){
        if($comment->getCommentary_response_id() === $this->getId()){return true;}
        else {return false;}
    }
    public function getChilds(){
        return $this->childs;
    }
    /*ClASS FUNCTIONS*/
    /*PRIVATES FUNCTIONS*/
    private function renderCommentary(){

    }
    /*PRIVATES FUNCTIONS*/
}