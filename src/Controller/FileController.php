<?php

namespace App\Controller;

class FileController {
    public function js($filePath){
        if (file_exists(path."assets/js/".$filePath)){
            header("Content-type: application/js");
            include(path."assets/js/".$filePath);
        }else{
            return header("HTTP/1.0 404 Not Found");
        }
    }
    public function jsVendor($filePath){
        if (file_exists(path."assets/js/vendor/".$filePath)){           
            header("Content-type: application/js");
            include(path."assets/js/vendor/".$filePath);
        }else{
            return header("HTTP/1.0 404 Not Found");
        }
    }
    public function css($filePath){
        if (file_exists(path."assets/css/".$filePath)){
            header("Content-type: text/css");
            include(path."assets/css/".$filePath);
        }else{
            return header("HTTP/1.0 404 Not Found");
        }
    }
    public function png($filePath){
        if (file_exists(path."assets/images/".$filePath)){
            header("Content-type: image/png");
            include(path."assets/images/".$filePath);
        }else{
            return header("HTTP/1.0 404 Not Found");
        }
    }
    public function jpg($filePath){
        if (file_exists(path."assets/images/".$filePath)){
            header("Content-type: image/jpeg");
            include(path."assets/images/".$filePath);
        }else{
            return header("HTTP/1.0 404 Not Found");
        }
    }
}