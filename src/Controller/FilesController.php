<?php

namespace App\Controller;

class FilesController {
    public function css($filePath){
        $this->fileExist(path."src/assets/css/".$filePath, "text/css");
    }
    public function js($filePath){
        $this->fileExist(path."src/assets/js/".$filePath, "application/javascript");
    }
    public function png($filePath){
        $this->fileExist(path."src/assets/images/".$filePath, "image/png");
    }
    public function jpg($filePath){
        $this->fileExist(path."src/assets/images/".$filePath, "image/jpg");
    }
    private function fileExist($fullFilePath,$fileMimeType){
        if (file_exists($fullFilePath)){
            header("Content-type: ".$fileMimeType);
            include($fullFilePath);
        }else{
            return header("HTTP/1.0 404 Not Found");
        }
    }

}