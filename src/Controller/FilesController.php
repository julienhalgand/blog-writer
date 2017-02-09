<?php

namespace App\Controller;

class FilesController {
    public function js($filePath){
        if (file_exists(path."assets/js/".$filePath)){
            header("Content-type: application/js");
            include(path."assets/js/".$filePath);
        }else{
            return header("HTTP/1.0 404 Not Found");
        }
    }
}