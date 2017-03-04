<?php
namespace App\PDOManager;

class PostManager extends PDOManager{

    public function __construct(){
        parent::__construct('post');
    }

    public function findCommentaries(){
        
    }
}