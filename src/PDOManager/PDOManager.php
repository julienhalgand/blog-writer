<?php
namespace App\PDOManager;

abstract class PDOManager{
    protected $PDO;
    protected $obj;

    public function __construct($obj){
        try {
            $this->PDO = new \PDO('mysql:host=localhost;dbname=blog_writer', 'root', 'root', array(\PDO::ATTR_ERRMODE, \PDO::ERRMODE_WARNING));
            $this->PDO->setAttribute(\PDO::ATTR_EMULATE_PREPARES,false); 
        } catch (PDOException $e) {
            print "Erreur !: " . $e->getMessage() . "<br/>";
            die();
        }
        $this->obj = $obj;
    }

    public function find($numberOfResults, $page){
        $minLimit = ($page-1)*$numberOfResults;
        $req = $this->PDO->query("SELECT * FROM ".$this->obj." LIMIT ".$minLimit.",".$numberOfResults);
        return $req->fetchAll();
    }
    public function findBy($by,$value,array $fieldsReturnedArray){
        return $this->findByRequest($by,$value,$fieldsReturnedArray)->fetchAll(\PDO::FETCH_ASSOC);
    }
    public function findObjectBy($by,$value,array $fieldsReturnedArray){
        return $this->findByRequest($by,$value,$fieldsReturnedArray)->fetchAll(\PDO::FETCH_CLASS, "\\App\\Model\\".ucfirst($this->obj));
    }
    public function findObjectByOrderBy($by,$value,array $fieldsReturnedArray,$orderBy){
        return $this->findByRequest($by,$value,$fieldsReturnedArray,NULL,$orderBy)->fetchAll(\PDO::FETCH_CLASS, "\\App\\Model\\".ucfirst($this->obj));
    }
    public function findObjectByGroupBy($by,$value,array $fieldsReturnedArray, $groupBy){
        return $this->findByRequest($by,$value,$fieldsReturnedArray,$groupBy)->fetchAll(\PDO::FETCH_CLASS, "\\App\\Model\\".ucfirst($this->obj));
    }
    public function count(){
        return $this->PDO->query("SELECT COUNT(*) FROM ".$this->obj)->fetch()["COUNT(*)"];
    }
    public function existBy($by, $value){
        return $this->PDO->query("SELECT * FROM ".$this->obj." WHERE ".$by." = '".$value."'");        
    }
    public function findOneBy($by,$value,array $fieldsReturnedArray){
        return $this->findByRequest($by,$value,$fieldsReturnedArray)->fetch();
    }
    public function findDesc($numberOfResults, $page){
        $minLimit = ($page-1)*$numberOfResults;
        $req = $this->PDO->query("SELECT * FROM ".$this->obj." ORDER BY created_at DESC LIMIT ".$minLimit.",".$numberOfResults);
        return $req->fetchAll();
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
        $req = $this->PDO->prepare("INSERT INTO ".$this->obj." (".$attributesString.") VALUES (".$valuesString.")");
        $req->execute($arrayObj);
    }
    public function update($id,$arrayObj){
        $valuesString = "";
        $numItems = count($arrayObj);
        $i = 0;
        foreach($arrayObj as $key => $value){
            if(++$i === $numItems){
                $valuesString = $valuesString.$key." = '".$value."'";
            }else{
                $valuesString = $valuesString.$key." = '".$value."', ";
            }
        }
        $req = $this->PDO->prepare("UPDATE ".$this->obj." SET ".$valuesString." WHERE id =".$id);
        $req->execute();
    }
    public function delete($id){
        $req = $this->PDO->prepare("DELETE FROM ".$this->obj." WHERE id =".$id);
        $req->execute();
    }

    private function findByRequest($by,$value,array $fieldsReturnedArray, $groupBy = NULL, $orderBy = NULL){
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
        if($groupBy === NULL && $orderBy === NULL){return $req = $this->PDO->query("SELECT ".$fieldsReturned." FROM ".$this->obj." WHERE ".$by." = '".$value."'");}
        else if ($orderBy === NULL){return $req = $this->PDO->query("SELECT ".$fieldsReturned." FROM ".$this->obj." WHERE ".$by." = '".$value."' GROUP BY ".$groupBy);}
        else if ($groupBy === NULL){return $req = $this->PDO->query("SELECT ".$fieldsReturned." FROM ".$this->obj." WHERE ".$by." = '".$value."' ORDER BY ".$orderBy);}
        else{return $req = $this->PDO->query("SELECT ".$fieldsReturned." FROM ".$this->obj." WHERE ".$by." = '".$value."' GROUP BY ".$groupBy);}
    }

    public function getPDO(){
        return $this->PDO;
    }
    public function getObj(){
        return $this->obj;
    }
}