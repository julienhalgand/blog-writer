<?php
namespace App\PDOManager;

class ReportManager extends PDOManager{

    public function __construct(){
        parent::__construct('report');
    }
    public function existByUserCommentary($userId, $commentaryId){
        return $this->PDO->query("SELECT * FROM ".$this->obj." WHERE user_id = ".$userId." AND commentary_id = ".$commentaryId)->fetch();        
    }
}