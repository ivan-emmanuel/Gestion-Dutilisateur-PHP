<?php
/**
 * Created by PhpStorm.
 * User: ledev
 * Date: 06/03/2019
 * Time: 09:55
 */

namespace Application\Router;


class Route
{
    private $path;
    public $callable;
    private $matches = [];
    private $params = [];
    private $name = null;
    private $middlewares = [];

    public function __construct($path,$callable)
    {
        $this->path  = trim($path,'/');
        $this->callable  = $callable;
    }

    public function routeMiddleware(){

    }

    public function getPath($params){
        $path = $this->path;
        foreach ($params as $k => $v){
          $path = str_replace(":$k",$v,$path);
        }
        return '/'.$path;
    }

    public function getName()
    {
        return $this->name;
    }

    public function name($name){
        $this->name = $name;
        return $this;
    }

    public function with($param,$regex){
        $this->params[$param] = str_replace('(','(?:',$regex);
        return $this;
    }

    public function match($url){
        $url = trim($url,'/');
        $path = preg_replace_callback('#:([\w]+)#',[$this,'paramMatch'], $this->path);
        $regex = "#^$path$#i" ;
        if ( !preg_match($regex,$url,$matches) ){
            return false;
        }
        array_shift($matches);
        $this->matches = $matches ;
        return true;
    }

    private  function paramMatch($match){
        if ( isset($this->params[$match[1]]) )  {
            return '('.$this->params[$match[1]].')';
        }
        return '([^/]+)' ;
    }

    public function call($controller_namespace ){
        $_GET['_params'] = $this->matches;
        if (is_string($this->callable)){
            $params = explode('#',$this->callable);
            $controller = $controller_namespace . $params[0] . "sController";
            $controller = new $controller();
            return call_user_func_array([$controller,$params[1]],$this->matches);
        }else{
            return call_user_func_array($this->callable,$this->matches);
        }
    }

    public function params(){
            return $_GET['_params'];
    }


}