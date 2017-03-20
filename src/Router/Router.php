<?php

namespace App\Router;

class Router {

    private $url;
    private $routes = [];
    private $namedRoutes = [];
    private $loader;
    private $twig;

    public function __construct($url){
        $this->loader = new \Twig_Loader_Filesystem(path."Views");
        $this->twig =   new \Twig_Environment($this->loader, 
            ['cache' =>  false //'/../tmp'
        ]);
        $this->url = $url;
    }
    public function get( $path, $rules, $callable, $name){
        return $this->add($path, $rules, $callable, $name, 'GET');
    }
    public function post( $path, $rules, $callable, $name){
      return $this->add($path, $rules, $callable, $name, 'POST');
    }
    public function put( $path, $rules, $callable, $name){
        return $this->add($path, $rules, $callable, $name, 'PUT');
    }
    public function delete( $path, $rules, $callable, $name){
      return $this->add($path, $rules, $callable, $name, 'DELETE');
    }
    private function add( $path, $rules, $callable, $name, $method){
        $route = new Route($path,$callable,$rules);
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
            if($route->match($this->url)){
                $policiesManager = new \App\Policies\PoliciesManager($route->getRules());
                $policiesManager->applyTheLaw();
                return $route->call();
            }
        }
        $this->notFound();
    }
    public function url($name, $params = []){
        if(!isset($this->namedRoutes[$name])){
            http_response_code(404);
            echo $this->twig->render('404.twig', array('title' => "Cette page n'existe pas ou plus !"));
            die;
        }
        $this->namedRoutes[$name]->getUrl($params);
    }
    public function notFound(){
        http_response_code(404);
        echo $this->twig->render('404.twig', array('title' => "Cette page n'existe pas ou plus !"));
        die;
    }
}