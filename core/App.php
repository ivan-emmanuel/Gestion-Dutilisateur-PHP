<?php

 namespace Application;

 use app\controllers\welcomesController;
 use Application\Router\Router;

 class App{

     static $app = null;

     public static function  run($url){
        require '';
        if (!is_null(self::$app)){

        }else{
            return new \Exception("ne Instance of Application is already in running");
        }
     }
 }