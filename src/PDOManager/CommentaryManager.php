<?php
namespace App\PDOManager;

class CommentaryManager extends PDOManager{

    public function __construct(){
        parent::__construct('commentary');
    }
}