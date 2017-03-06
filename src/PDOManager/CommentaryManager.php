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
}