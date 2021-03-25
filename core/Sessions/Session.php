<?php

namespace Application\Sessions;

use Application\Helpers\Collection;


class Session
{

    static  $instance = null;

    static function getInstance()
    {
        if ( is_null(self::$instance) )
        {
            self::$instance = new Session();
        }
        return self::$instance ;
    }

    public function __construct()
    {
        session_start();
    }

    public function setFlash($key, $message, $title)
    {
        $_SESSION['flash'][$key] = ['msg'=>$message,'title'=>$title];
    }


    public function all()
    {
        $session = self::getInstance();
        return new Collection($_SESSION);
    }


    public function hasFlashes()
    {
        return isset($_SESSION['flash']);
    }

    public function getFlashes()
    {
        $flash = !empty($_SESSION['flash']) ? $_SESSION['flash'] : null ;
        unset($_SESSION['flash']);
        return $flash;
    }

    public function deleteFlash(){
        unset($_SESSION['flash']);
    }

    public function write($key, $value)
    {
        $_SESSION[$key] = $value ;
    }

    public function read($key,$collection = false)
    {
		if( $collection ){
			return isset($_SESSION[$key]) ? new Collection($_SESSION[$key]) : null ;
		}
        return isset($_SESSION[$key]) ? $_SESSION[$key] : null ;
    }

    public function delete($key)
    {
        unset($_SESSION[$key]);
    }

}
