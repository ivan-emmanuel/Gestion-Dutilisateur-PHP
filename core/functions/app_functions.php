<?php

use Application\Auth;
use Application\Models\DB;
use Application\Paths;

function all_users($value = '')
{
    $data = [];
    $all = DB::Instance()->query('SELECT longitude,latitude,name,id,type FROM users ')->fetchAll();
    return $all;

}


function url($path = null): string
{
    $pref = (!empty($path) && $path[0] == '/') ? '' : '/';
    return Paths::Instance()->HttpPath($pref . $path);
}


function ddump(...$vars)
{
    echo "<pre>";
    var_dump($vars);
    echo "<pre>";
    exit();
}


function path_for(string $routeName, array $params = [])
{
    return url(router_instance()->getPath($routeName, $params));
}

function request_get()
{
    return new \Application\Helpers\Collection($_GET);
}

function request_post(?string $param = null)
{
    if (!is_null($param)) {
        return (new \Application\Helpers\Collection($_POST))->get($param);
    }
    return new \Application\Helpers\Collection($_POST);
}


function random_str($length)
{
    $alphabel = "0123456789azertyuiopqsdfghjklmwxcvbnAZERTYUIOPQSDFGHJKLMWXCVBN";
    return substr(str_shuffle(str_repeat($alphabel, 60)), 0, $length);
}

function hash_password($password)
{
    return password_hash($password, PASSWORD_BCRYPT);
}

function check_password($password, $hash)
{
    return password_verify($password, $hash);
}



function soft_user_type($type)
{
    if ($type == 'admin') {
        return 'Admin';
    } elseif ($type == 'user') {
        return 'Utilisateur';
    }
}


function check_internet_connexion()
{
    // use 80 for http or 443 for https protocol
    $connected = @fsockopen("www.google.com", 80);
    if ($connected) {
        fclose($connected);
        return true;
    }
    return false;
}


function UserIsIn(array $type)
{
    return in_array(Auth::getUser()->type, $type, false);
}

function UserNotIn(array $type)
{
    return !in_array(Auth::getUser()->type, $type, false);
}




