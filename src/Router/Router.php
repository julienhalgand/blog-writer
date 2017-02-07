<?php

namespace App\Router;

class Router {

    private $url;
    private $routes = [];
    private $namedRoutes = [];

    public function __construct($url){
        $this->url = $url;
    }
    public function get($path, $callable, $name){
        return $this->add($path, $callable, $name, 'GET');
    }
    public function post($path, $callable, $name){
      return $this->add($path, $callable, $name, 'POST');
    }
    public function put($path, $callable, $name){
        return $this->add($path, $callable, $name, 'PUT');
    }
    public function delete($path, $callable, $name){
      return $this->add($path, $callable, $name, 'DELETE');
    }
    private function add($path, $callable, $name, $method){
        $route = new Route($path,$callable);
        $this->routes[$method][] = $route;
        if($name){
            $this->namedRoutes[$name] = $route;
        }
        return $route;
    }

    public function run(){
        if(!isset($this->routes[$_SERVER['REQUEST_METHOD']])){
            throw new RouterException('REQUEST_METHOD doesn\'t exist.');
        }
        foreach($this->routes[$_SERVER['REQUEST_METHOD']] as $route){
            //print_r($route);
            //print_r($this->url);
            if($route->match($this->url)){
                return $route->call();
            }
        }
        throw new RouterException('No matching routes.');
    }
    public function url($name, $params = []){
        if(!isset($this->namedRoutes[$name])){
           return header("HTTP/1.0 404 Not Found");
        }
        $this->namedRoutes[$name]->getUrl($params);
    }
}