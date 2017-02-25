<?php
namespace App\PDOManager;

class SessionManager extends PDOManager{

    public function __construct(){
        parent::__construct('session');
   }
}