<?php

namespace App\Router;
 
class Route {
    private $path;
    private $callable;
    private $matches = [];
    private $params = [];

    public function __construct($path, $callable){
        $this->path = trim($path ,'/');
        $this->callable = $callable;
    }
    
    public function with($param, $regex){
        $this->params[$param] = str_replace('(', '(?:', $regex);
        return $this;
    }
    public function match($url){
        $url = trim($url, '/');
        $path = preg_replace_callback('#:([\w]+)#',[$this, 'paramMatch'], $this->path);
        print($path."</br>");
                
        
        $regex = '#^'.$path.'$#';
        print($regex."</br>");
        print($url);
        if(preg_match($regex, $url, $matches)){

            array_shift($matches);
            print($matches);
            $this->matches = $matches;
            return true;
        }

        return false;
    }

    private function paramMatch($match){
        if(isset($this->params[$match[1]])){
            return '('.$this->params[$match[1]].')';
        }
        return '([^/]+)';
    }

    public function call(){        
        if(is_string($this->callable)){
            $params = explode('.', $this->callable);
            $controller = "App\\Controller\\".$params[0]."Controller";
            $controller = new $controller();
            return call_user_func_array([$controller, $params[1]], $this->matches);
            var_dump($params);
            $action = $params[1];
            return $controller->action();
        }else{
            return call_user_func_array($this->callable, $this->matches);            
        }
    }
    public function getUrl($params){
        $path = $this->path;
        foreach($params as $k => $v){
            $path = str_replace(":$k", $v, $path);
        }
        return $path;
    }
}