<?php
namespace App\PDOManager;

class UserManager extends PDOManager{

    public function __construct(){
        parent::__construct('user');
    }

}