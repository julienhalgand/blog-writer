<?php
namespace App\PDOManager;

class CommentaryManager extends PDOManager{

    public function __construct(){
        parent::__construct('commentary');
    }
    public function findPostCommentaries($fieldsReturned,$by,$value){
        $req = $this->getPDO()->query("SELECT ".$fieldsReturned." FROM ".$this->getObj()." LEFT JOIN ".$this->getObj()." as response ON ".$this->getObj().".id = response.commentary_response_id WHERE ".$this->getObj().".post_id = ".$value);
        return $req->fetchAll();
        //SELECT id, prenom, nom, date_achat, num_facture, prix_total
        //FROM utilisateur
        //INNER JOIN commande ON utilisateur.id = commande.utilisateur_id
    }
    public function findReportsWhen($numberOfResults, $page, $where, $test, $value){
        $minLimit = ($page-1)*$numberOfResults;
        $req = $this->PDO->query("SELECT * FROM ".$this->obj." WHERE ".$where." ".$test." ".$value." ORDER BY ".$where." DESC LIMIT ".$minLimit.",".$numberOfResults);
        return $req->fetchAll();
    }
    public function countReportsWhere($where, $test, $value){
        return $this->PDO->query("SELECT COUNT(*) FROM ".$this->obj." WHERE ".$where." ".$test." ".$value)->fetch()["COUNT(*)"];
    }
}