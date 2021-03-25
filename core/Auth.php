<?php


namespace Application;


class Auth
{

    static function log($user){
        session_instance()->write('user',$user);
    }

    static function getUser(){
        return session_instance()->read('user');
    }
	
	static function isLogged(){
        return !empty(session_instance()->read('user'));
    }
	
	static function isAdmin(){
		//ddump($_SESSION);
        return  (self::isLogged() && Auth::getUser()->type === "admin") ;
    }
	
	

    static function logOut(){
        session_instance()->delete('user');
    }

}