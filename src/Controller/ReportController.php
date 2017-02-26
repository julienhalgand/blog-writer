<?php
namespace App\Controller;

use Respect\Validation\Validator as v;

class ReportController extends ObjectController{

    public function __construct(){
        parent::__construct("Report");
    }
    public function index(){
        echo $this->twig->render('Report/index.twig');
    }
    public function create($slug, $id){
        
    }
    public function update($slug, $id){
        
    }
    public function delete($slug, $id){
        
    }
}