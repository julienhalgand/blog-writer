<?php

namespace App\Policies;

class PoliciesManager {
    private $rulesArray;

    public function __construct($rulesArray){
        $this->rulesArray = $rulesArray;
    }

    public function applyTheLaw(){
        foreach($this->rulesArray as $rule){
            include("Rules/".$rule.".php");
        }
    }
}