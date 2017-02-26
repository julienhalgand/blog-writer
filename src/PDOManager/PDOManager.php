<?php
namespace App\PDOManager;

abstract class PDOManager{
    private $PDO;
    private $obj;

    public function __construct($obj){
        try {
            $this->PDO = new \PDO('mysql:host=localhost;dbname=blog_writer', 'root', 'root', array(\PDO::ATTR_ERRMODE => \PDO::ERRMODE_WARNING));
            $this->PDO->setAttribute(\PDO::ATTR_EMULATE_PREPARES,false); 
        } catch (PDOException $e) {
            print "Erreur !: " . $e->getMessage() . "<br/>";
            die();
        }
        $this->obj = $obj;
    }

    public function find($numberOfResults, $page){
        $minLimit = ($page-1)*$numberOfResults;
        $maxLimit = $page*$numberOfResults;
        return $this->PDO->query("SELECT * FROM ".$this->obj." LIMIT ".$minLimit.",".$maxLimit);
    }
    public function findOneBy($by,$value,array $fieldsReturnedArray){
        $fieldsReturned = "";
        $numItems = count($fieldsReturnedArray);
        $i = 0;
        foreach($fieldsReturnedArray as $fieldReturned){
            if(++$i === $numItems){
                $fieldsReturned = $fieldsReturned.$fieldReturned;
            }else{
                $fieldsReturned = $fieldsReturned.$fieldReturned.",";
            }         
        }
        $req = $this->PDO->query("SELECT ".$fieldsReturned." FROM ".$this->obj." WHERE ".$by." = '".$value."'");
        return $req->fetch();
    }
    public function create($arrayObj){
        $attributesString = "";
        $valuesString = "";
        $numItems = count($arrayObj);
        $i = 0;
        foreach($arrayObj as $key => $value){
            if(++$i === $numItems){
                $attributesString = $attributesString.$key;
                $valuesString = $valuesString.":".$key;
            }else{
                $attributesString = $attributesString.$key.",";
                $valuesString = $valuesString.":".$key.",";
            }
        }
        var_dump("INSERT INTO ".$this->obj." (".$attributesString.") VALUE (".$valuesString.")");
        $req = $this->PDO->prepare("INSERT INTO ".$this->obj." (".$attributesString.") VALUES (".$valuesString.")");

        $req->execute($arrayObj);
    }
    public function update($id){

    }
    public function delete($id){

    }
}