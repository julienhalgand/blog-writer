<?php

namespace App\Controller;

class PDOController{
    private $PDO;

    public function __construct(){
        $this->PDO = new PDO("mysql:dbname=blog_writer;host=localhost","root","");
        $this->PDO->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
        $this->PDO->setAttribute(PDO::ATTR_DEFAULT, PDO::FETCH_OBJ);
    }

    public function find(string $obj, string $limit){
        $this->PDO->query("SELECT * FROM ".$obj." LIMIT ".$limit);
    }
}