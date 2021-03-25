<?php


namespace App\Controllers\auth;

use Application\Template\TemplateEngine;
use function middlewares\isAuthPage;
 use \Application\Auth;
 use \PDO;


class AccountsController
{

	public function edit()
	{
        isAuthPage();
        $pdo = pdo_instance();
        $POST = CollectionData($_POST);
        $errors = [];
        $auth = Auth::getUser();
        $id = $auth->id;
        if( !filter_var($POST->get('login'),FILTER_SANITIZE_STRING,['options'=>['max_range'=>'255']]) ){
            $errors['login'] = "format du login invalide";
        }
        if( !filter_var($POST->get('name'),FILTER_SANITIZE_STRING,['options'=>['max_range'=>'255']]) ){
            $errors['name'] = "format du nom invalide";
        }
        if($POST->get('password') != $POST->get('password_confirmation')){
            $errors['password'] = "Confirmation de mot de passe invalide";
        }
        if($POST->get('password') != $POST->get('password_confirmation')){
            $errors['password'] = "Confirmation de mot de passe invalide";
        }
        $login_query = $pdo->prepare("SELECT * FROM users 
        	WHERE login = :login AND id != '$id' ");
        $login_query->execute(['login'=>$POST->get('login')]);
        if( $login_query->rowCount() ){
            $errors['login_uniq'] = "login déjà existant en base de donnée";
        }
        if( empty($errors) ){
            $db = $pdo->prepare("UPDATE users    
            SET login = :login , name= :name ,password = :password 
            WHERE id = '$id' ");
            $db->bindValue("login",$POST->get('login'),PDO::PARAM_STR);
            $db->bindValue("name",$POST->get('name'),PDO::PARAM_STR);
            $db->bindValue("password",hash_password(request_post('password')),PDO::PARAM_STR);
            $db->execute();
            setSuccesFlash("Compte créé .un mail a été envoyer a l'email utilisateur pour confirmer son compte.","Inscription utilisateur");
            route_redirect('admin.home');
        }else{
            session_instance()->write('_data',$_POST);
            session_instance()->write('errors',$errors);
            route_redirect('admin.home');
        }
	}


}