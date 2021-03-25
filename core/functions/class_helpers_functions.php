<?php

use Application\Sessions\Session;

function pdo_instance(){
    return  \Application\Models\DB::Instance()->getPdo();
}

function router_instance(){
    return \Application\Router\Router::Instance();
}

function CollectionData($data)
{
    return new \Application\Helpers\Collection($data);
}
function session_instance($param = null){
    if(empty($param)){
        return Session::getInstance();
    }
    return Session::getInstance()->read($param);
}

