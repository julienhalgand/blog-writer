<?php
namespace App\Controller;

use Respect\Validation\Validator as v;

class CommentaryController extends ObjectController{

    public function __construct(){
        parent::__construct("Commentary");
    }
    public function index(){
        echo $this->twig->render('Commentary/index.twig');
    }
    public function edit($slug, $id){
        echo $twig->render('Commentary/edit.twig');
    }
    public function create($slug, $id){
        
    }
    public function update($slug, $id){
        
    }
    public function delete($slug, $id){
        
    }
}