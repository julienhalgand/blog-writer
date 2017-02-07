<?php

namespace App\Controller;
 
class PostsController {
    public function show($slug, $id){
        include(__DIR__."/../Views/layout.php");
    }
}