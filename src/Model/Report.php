<?php

namespace App\Model;
 
class Report {
    private $id;
    private $commentaryId;
    private $userId;

    public function __construct($id,$commentaryId,$userId,$tags,$content){
        $this->id = $id;
        $this->commentaryId = $commentaryId;
        $this->userId = $userId;
    }

    public function getId(){
        return $this->id;
    }
    public function getCommentaryId(){
        return $this->commentaryId;
    }
    public function getUserId(){
        return $this->userId;
    }

}