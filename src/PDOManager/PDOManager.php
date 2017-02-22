<?php
namespace App\PDOManager;

class PDOManager{
    private $PDO;

    public function __construct(){
        try {
            $this->PDO = new \PDO('mysql:host=localhost;port:3306;dbname=blog_writer', 'root', 'root');
        } catch (PDOException $e) {
            print "Erreur !: " . $e->getMessage() . "<br/>";
            die();
        }
    }

    public function find(string $obj, string $limit){
        return $this->PDO->query("SELECT * FROM ".$obj." LIMIT ".$limit);
    }
    public function findOne(string $obj, string $id){
        return $this->PDO->query("SELECT * FROM ".$obj." LIMIT 1");
    }
}