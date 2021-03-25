<?php




function redirect_to($path){
    header("location:$path");
    exit();
}

function route_redirect($routeName,$params = []){
    header("location:".path_for($routeName,$params));
    exit();
}
