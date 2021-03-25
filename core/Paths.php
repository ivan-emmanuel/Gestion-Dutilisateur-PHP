<?php


namespace Application;


class Paths
{

    private $http_host;

    private $app_dir;

    private $public_dir;

    private $view_dir;

    private $controller_dir;

    private $config_dir;

    private static $instance = null;

    /**
     * Paths constructor.
     */
    public function __construct()
    {
        // Default value to NULL for CLI Mode
        $this->http_host = $_SERVER['HTTP_HOST'] ?? null;
        $this->app_dir = APP_BASE_DIR;
        $this->controller_dir =  APP_BASE_DIR.'/app/Controllers';
        $this->view_dir =  APP_BASE_DIR.'/app/Views';
        $this->public_dir =  APP_BASE_DIR.'/webroot';
        $this->config_dir =  APP_BASE_DIR.'/configs';
    }

    /**
     * @return mixed
     */
    public function HttpPath(?string $suit)
    {
        if ( !empty($_SERVER['HTTPS']) ) {
            return 'https://'.$this->http_host.$suit;
        }

        if ( !empty($_SERVER['HTTP_X_FORWARDED_PROTO']) and  $_SERVER['HTTP_X_FORWARDED_PROTO'] === "https") {
            return 'https://'.$this->http_host.$suit;
        }
        return 'http://'.$this->http_host.$suit;
    }

    /**
     * @return string
     */
    public function Base(?string $dir_suit = null): string
    {
        return $this->app_dir.'/'.$dir_suit;
    }

    /**
     * @return string
     */
    public function Controller(?string $dir_suit = null): string
    {
        return $this->controller_dir.'/'.$dir_suit;
    }

    /**
     * @return string
     */
    public function View(?string $dir_suit = null): string
    {
        return $this->view_dir.'/'.$dir_suit;
    }

    /**
     * @return string
     */
    public function Layout(?string $dir_suit = null): string
    {
        return $this->View('layouts').'/'.$dir_suit;
    }


    /**
     * @return string
     */
    public function Public(?string $dir_suit = null): string
    {
        return $this->public_dir.'/'.$dir_suit;
    }


    /**
     * @return string
     */
    public function Config(?string $dir_suit = null): string
    {
        return $this->config_dir.'/'.$dir_suit;
    }


    public static function Instance(){
        if ( is_null(self::$instance) ){
            self::$instance = new Paths();
        }
        return self::$instance;
    }


}