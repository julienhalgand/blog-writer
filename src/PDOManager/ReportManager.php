<?php
namespace App\PDOManager;

class ReportManager extends PDOManager{

    public function __construct(){
        parent::__construct('report');
    }
}