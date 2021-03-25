<?php

use Application\Sessions\Session;

function setSuccesFlash($msg, $title){
    Session::getInstance()->setFlash('success',$msg,$title);
}
function setErrorFlash($msg,$title){
    Session::getInstance()->setFlash('danger',$msg,$title);
}
function setFlash($type,$msg,$title){
    Session::getInstance()->setFlash($type,$msg,$title);
}
function session_data(){
  session_instance()->all();
}
