<?php
/**
 * Created by PhpStorm.
 * User: ledev
 * Date: 06/03/2019
 * Time: 09:31
 */

namespace Application\Router;


use App\Controllers\HomesController;

class Router
{

    private $url ,$current_route, $routes = [],$namedRoutes = [];
    private $controller_namespace  ;
    private static $instance = null;

    static function Instance() : Router {
        if (empty(self::$instance)){
            return self::$instance = new Router($_SERVER['REQUEST_URI'] ?? "");
        }
        return  self::$instance ;
    }

    public function __construct($url,$controller_namespace = "App\\Controllers\\")
    {
        $this->url = $url ;
        $this->controller_namespace = $controller_namespace;
    }

    public function getCurrentRoute() : Route
    {
        return $this->current_route;
    }

    public function get($path,$callable,$name=null){
        if( empty($name) ){
            return $this->addRoute($path,$callable,'GET');
        }
        return $this->addRoute($path,$callable,'GET')->name($name);
    }

    public function post($path,$callable,$name=null){
        if( empty($name) ){
            return $this->addRoute($path,$callable,'POST');
        }
        return $this->addRoute($path,$callable,'POST')->name($name);
    }

    private function addRoute($path,$callable,$method){
        $route = new Route($path,$callable);
        $this->routes[$method][] = $route;
        if ( is_string($callable) ){
            $route->name($callable);
        }
        return $route;
    }

    public function run() {
        $request_method = $_SERVER['REQUEST_METHOD'] ?? "";
        if ( !isset($this->routes[$request_method]) ){
            throw  new RouterException('[Exception Router]: Page Inexistante , $_SERVER[\'REQUEST_METHOD\'] est null  ');
        }
        foreach ($this->routes as $routes){
            foreach ($routes AS $route){
                $this->namedRoutes[$route->getName()] = $route;
            }
        }
        foreach ($this->namedRoutes as $route){
            if ($route->match($this->url) && in_array($route,$this->routes[$request_method])){
                $this->current_route = $route;
                return $route->call($this->controller_namespace);
            }
        }
        //throw  new RouterException("No matching routes ");
         (new HomesController())->e404();
        exit();
    }

    public function getPath($name,$params = []){
        if ( !isset($this->namedRoutes[$name]) ) {
            throw  new RouterException("No matching routes for name $name ");
        }
        return $this->namedRoutes[$name]->getPath($params);
    }


}