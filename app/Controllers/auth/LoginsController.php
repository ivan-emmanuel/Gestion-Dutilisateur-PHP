<?php


namespace App\Controllers\auth;

use Application\Auth;
use Application\Models\DB;
use Application\Template\TemplateEngine;
use App\Models\UserModel;
use function middlewares\isGuestPage;


class loginsController
{

	public function home()
	{
        isGuestPage();
		TemplateEngine::Instance()->setLayout('guest');
        TemplateEngine::Instance()->render('auth/login');
	}


	public function homeAction(){
        isGuestPage();
        $pdo = pdo_instance();
        $POST = CollectionData($_POST);
        $db = $pdo->prepare("SELECT * FROM users   WHERE login = :login  AND confirmed_at IS NOT NULL  ");
        $db->bindValue('login',$POST->get('login'),\PDO::PARAM_STR);
        $db->execute();
        $user = $db->fetch();
        if ( !empty($user) && check_password($POST->get('password'),$user->password)      ){
			Auth::log($user);
            setSuccesFlash("Connexion effectué avec success",'Connexion');
            route_redirect('admin.home');
        }else{
            setErrorFlash("Login ou mot de passe incorrect",'Connexion');
            header("location:".path_for('login.home'));
            exit();
        }
    }

    public function logout(){
	    Auth::logOut();
	    setSuccesFlash("Vous êtes maintenant déconnecter","Deconnexion");
	    header('location:'.path_for('login.home'));
	    exit();
    }

}