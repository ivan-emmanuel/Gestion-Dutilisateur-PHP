<?php


namespace Application;


use Application\Helpers\Collection;

class Configs
{
    private $appConfig;
    private static $configs = null;

    public static function Instance(){
        if (is_null(self::$configs)){
            self::$configs =  new Configs();
        }
        return self::$configs;
    }

    public function __construct()
    {
        $this->appConfig = require Paths::Instance()->Config('/app.php');
    }


    public function getAppConfig() : Collection
    {
        return new Collection( $this->appConfig);
    }


}