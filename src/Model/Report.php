<?php

namespace App\Model;
 
class Report {
    private $id,
            $created_at,
            $updated_at,
            $commentaryId,
            $userId;

    public function __construct(){
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